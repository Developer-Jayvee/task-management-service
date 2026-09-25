<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{

    public function __construct(
        protected ProjectService $_projectService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->_projectService->getList();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {

        $this->authorize('create',Project::class);

        return $this->_projectService->storeProject($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view',$project);

        return $this->successResponse(
            data : new ProjectResource($project)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update',$project);

        return $this->_projectService->updateProject(
            $project,
            $request->all()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete',$project);
        
        return $this->_projectService->deleteProject($project);
    }

    public function getProjectTickets(Project $project)
    {
        return $this->_projectService->getProjectTickets($project);
    }
}
