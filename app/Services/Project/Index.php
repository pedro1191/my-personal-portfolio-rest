<?php

namespace App\Services\Project;

use App\Enums\SearchResultType;
use App\Models\Project;

class Index
{
    public function execute(array $data)
    {
        $query = Project::query()
            ->when($data['name'] ?? null, function ($query, $name) {
                $query->whereRaw('LOWER(name) LIKE ?')
                    ->setBindings([$name]);
            })
            ->when($data['description'] ?? null, function ($query, $description) {
                $query->whereRaw('LOWER(description) LIKE ?')
                    ->setBindings([$description]);
            })
            ->orderBy($data['orderBy'], $data['orderDirection']);

        if ($data['result'] === SearchResultType::Paginated->value) {
            return $query->paginate();
        }

        return $query->get();
    }
}
