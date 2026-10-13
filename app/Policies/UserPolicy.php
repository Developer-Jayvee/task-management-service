<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
   public function resetPassword(User $user)
   {
        return $user->can('user reset-password');
   }
}
