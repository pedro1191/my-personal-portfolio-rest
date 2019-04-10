<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct(\App\Project $project, \App\Transformers\ProjectTransformer $transformer)
    {
        $this->project = $project;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // User input validation
        $this->validate($request, [
            'name' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'orderBy' => ['sometimes', 'in:id,name,description,order'],
            'orderDirection' => ['sometimes', 'in:asc,desc'],
            'result' => ['sometimes', 'in:paginated,all']
        ]);

        $orderBy = $request->input('orderBy') ?? 'id';
        $orderDirection = $request->input('orderDirection') ?? 'desc';
        $result = $request->input('result') ?? 'all';

        $query = $this->project
            ->when($request->input('name'), function ($query, $name) {
                $q = ('%' . mb_strtolower(trim($name)) . '%');
                $query->where(function ($query) use ($q) {
                    $query->whereRaw('LOWER(name) LIKE ?')
                        ->setBindings([$q]);
                });
            })
            ->when($request->input('description'), function ($query, $description) {
                $q = ('%' . mb_strtolower(trim($description)) . '%');
                $query->where(function ($query) use ($q) {
                    $query->whereRaw('LOWER(description) LIKE ?')
                        ->setBindings([$q]);
                });
            })
            ->orderBy($orderBy, $orderDirection);

        if ($result === 'paginated') {
            $projects = $query->paginate(Controller::DEFAULT_PAGINATION_RESULTS);

            return $this->response->paginator($projects, $this->transformer);
        }

        $projects = $query->get();

        return $this->response->collection($projects, $this->transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // User input validation
        $this->validate($request, [
            'name' => ['required', 'min:1', 'max:100'],
            'description' => ['required', 'min:1', 'max:65535'],
            'image' => ['required', 'image', 'max:64'],
            'live_demo_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'source_code_link' => ['required', 'min:1', 'max:100'],
            'order' => ['required', 'integer', 'min:1', 'unique:projects,order']
        ]);

        $image = $this->generateBase64ImageString($request->file('image'));

        // Everything OK
        $project = $this->project->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'live_demo_link' => $request->input('live_demo_link') ?? null,
            'source_code_link' => $request->input('source_code_link'),
            'order' => $request->input('order'),
            'image' => $image
        ]);

        return $this->response->item($project, $this->transformer)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!($project = $this->project->find($id))) {
            return $this->response->errorNotFound();
        }

        return $this->response->item($project, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!($project = $this->project->find($id))) {
            return $this->response->errorNotFound();
        }

        // User input validation
        $this->validate($request, [
            'name' => ['sometimes', 'required', 'min:1', 'max:100'],
            'description' => ['sometimes', 'required', 'min:1', 'max:65535'],
            'image' => ['sometimes', 'required', 'image', 'max:64'],
            'live_demo_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'source_code_link' => ['sometimes', 'required', 'min:1', 'max:100'],
            'order' => ['sometimes', 'required', 'integer', 'min:1', "unique:projects,order,$id,id"]
        ]);

        if ($request->hasFile('image')) {
            $image = $this->generateBase64ImageString($request->file('image'));
        } else {
            $image = null;
        }

        // Everything OK
        $project->fill([
            'name' => $request->input('name') ?? $project->name,
            'description' => $request->input('description') ?? $project->description,
            'live_demo_link' => $request->input('live_demo_link') ?? $project->live_demo_link,
            'source_code_link' => $request->input('source_code_link') ?? $project->source_code_link,
            'order' => $request->input('order') ?? $project->order,
            'image' => is_null($image) ? $project->image : $image,
        ]);
        $project->save();

        return $this->response->item($project, $this->transformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($project = $this->project->find($id))) {
            return $this->response->errorNotFound();
        }

        $project->delete();

        return $this->response->array(['deleted_id' => (int)$id]);
    }

    /**
     * Generate base64 image string
     * 
     * @param $image
     * @return string
     */
    private function generateBase64ImageString($image)
    {
        return "data:{$image->getMimeType()};base64,"
            . base64_encode(file_get_contents($image->getPathname()));
    }
}
