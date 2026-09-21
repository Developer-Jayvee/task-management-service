<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
   
    public function update(User $user , Project $project) 
    {
        return $user->can('project update');
    }
    public function delete(User $user, Project $project)
    {
        return $user->can('project delete');
    }
    public function create(User $user)
    {
        return $user->can('project create');
    }
    public function view(User $user, Project $project)
    {
        return $user->can('project view');
    }
}
