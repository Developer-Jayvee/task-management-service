<?php

namespace App\Services;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\ResponseTrait;

class ProjectService
{
    use ResponseTrait;

    public function getList()
    {
        $projects = Project::query()->paginate(perPage : 10, page : 1);

        return ProjectResource::collection($projects);
    }

    public function storeProject(array $data)
    {
        try {
            $project = Project::query()->create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);
    
            return $this->successResponse(
                new ProjectResource($project)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
    
    public function deleteProject(Project $project) 
    {
        try {
            $project?->delete();    

            return $this->successResponse(
                message: "Successfully deleted"
            );

        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function updateProject(Project $project, array $data)
    {
        try {
            if(! $project ) {
                throw new \Exception("This project does not exist", 404);
            }
    
            $project->update($data);
    
            return $this->successResponse( data : $project->fresh() );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function showProject(int $id) 
    {
        try {
            $project = Project::query()->findOrFail($id);
    
            return $this->successResponse(
                data : $project
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
