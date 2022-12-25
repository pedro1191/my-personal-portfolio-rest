<?php

namespace App\Services\Project;

use App\Helpers\Base64;
use App\Models\Project;

class Store
{
    public function execute(array $data): Project
    {
        $base64Image = Base64::generateBase64String($data['image']);
        $data['image'] = $base64Image;

        $project = new Project($data);
        $project->save();

        return $project;
    }
}
