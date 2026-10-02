<?php

namespace App\Services;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\ResponseTrait;

class ProjectService
{
    use ResponseTrait;

    public function getList(?string $search = null, ?string $sort = null)
    {
        $projects = Project::query();
        if ($search) {
            $projects->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
                $query->orWhere('description', 'LIKE', "%$search%");
            });
        }
        if ($sort) {
            $projects->orderBy('created_at', $sort);
        }
        $projects = $projects->with(['tickets'])
            ->paginate(perPage : 10, page : 1);

        return ProjectResource::collection($projects);
    }

    public function storeProject(array $data)
    {
        try {
            $project = Project::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            return $this->successResponse(
                new ProjectResource($project)
            );
        } catch (\Exception $exception) {
            dd($exception);

            return $this->errorResponse($exception);
        }
    }

    public function deleteProject(Project $project)
    {
        try {
            $project?->delete();

            return $this->successResponse(
                message: 'Successfully deleted'
            );

        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function updateProject(Project $project, array $data)
    {
        try {
            if (! $project) {
                throw new \Exception('This project does not exist', 404);
            }

            $project->update($data);

            return $this->successResponse(data : $project->fresh());
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function showProject(int $id)
    {
        try {
            $project = Project::query()->with(['tickets'])->findOrFail($id);

            return $this->successResponse(
                data : new ProjectResource($project)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function getProjectTickets(int $projectId, ?string $status = null)
    {
        try {
            $role = request()->user()->member->role;
            $project = Project::query()->with(['tickets' => function ($query) use ($status,$role) {
                    if ($status && ! in_array($status, ['all'])) {
                        $query->where('status', $status);
                    }
                    // if($role->value === 'member') {
                    //     $query->where('assignee_id',request()->user()->id);
                    // }
                }])->where('id', $projectId)
                ->first();
            return $this->successResponse(
                data: $project
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
