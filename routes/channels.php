<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel(
    'App.Models.User.{id}',
    function (User $user, int $id) {
        $owner = $user->getTenant()->owner;
        return (int) $owner->user_id === $id;
    }
);