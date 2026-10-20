<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
   public function resetPassword(User $user)
   {
      return $user->can('user reset-password');
   }

   public function updatePermission(User $user)
   {
      return $user->can('user update-permission');
   }

   public function deactivateUser(User $user)
   {
      return $user->can('user deactivate');
   }
}
