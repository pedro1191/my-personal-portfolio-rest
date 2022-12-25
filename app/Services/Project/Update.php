<?php

namespace App\Services\Project;

use App\Helpers\Base64;
use App\Models\Project;

class Update
{
    public function execute(Project $project, array $data): Project
    {
        if (isset($data['image'])) {
            $base64Image = Base64::generateBase64String($data['image']);
            $data['image'] = $base64Image;
        }

        $project->update($data);

        return $project;
    }
}
