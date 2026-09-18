<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "membership";

    protected $fillable = [
        'user_id',
        'tenant_id',
        'role'
    ];

    protected $casts = [
        'role' => Roles::class
    ];
}
