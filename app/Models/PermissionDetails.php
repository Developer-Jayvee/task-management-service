<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionDetails extends Model
{
    protected $table = 'permission_details';

    protected $fillable = [
        'permission_id', 
        'label',
        'description'
    ];


}
