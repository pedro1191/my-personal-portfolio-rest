<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\Index as IndexRequest;
use App\Http\Requests\Project\Store as StoreRequest;
use App\Http\Requests\Project\Update as UpdateRequest;
use App\Http\Resources\Project as ProjectResource;
use App\Models\Project;
use App\Services\Project\Index as IndexService;
use App\Services\Project\Store as StoreService;
use App\Services\Project\Update as UpdateService;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Project\Index  $request
     * @param  \App\Services\Project\Index  $service
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request, IndexService $service)
    {
        $data = $request->validated();
        $projects = $service->execute($data);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Project\Store  $request
     * @param  \App\Services\Project\Store  $service
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, StoreService $service)
    {
        $data = $request->validated();
        $project = $service->execute($data);

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Project\Update  $request
     * @param  \App\Services\Project\Update  $service
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, UpdateService $service, Project $project)
    {
        $data = $request->validated();
        $updatedProject = $service->execute($project, $data);

        return new ProjectResource($updatedProject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }
}
