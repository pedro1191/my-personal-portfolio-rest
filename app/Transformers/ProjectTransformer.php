<?php
namespace App\Transformers;

use League\Fractal;

class ProjectTransformer extends Fractal\TransformerAbstract
{
    public function transform(\App\Project $project)
    {
        return [
            'id' => (int)$project->id,
            'name' => $project->name,
            'description' => $project->description,
            'image' => $project->image,
            'live_demo_link' => $project->live_demo_link,
            'source_code_link' => $project->source_code_link,
            'order' => $project->order,
            'link' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.projects.show', ['id' => $project->id]),
        ];
    }
}
