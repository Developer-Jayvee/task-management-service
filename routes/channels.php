<?php

use App\Models\Member;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel(
    'App.Models.Members.{id}',
    function (Member $member, int $id) {
        return (int) $member->id === $id;
    }
);