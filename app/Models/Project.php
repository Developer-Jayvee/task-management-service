<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Project extends Model
{
    protected $table = "projects";

    protected $fillable = [
        'tenant_id',
        'name',
        'description'
    ];

    #[Override]
    public static function boot()
    {
        static::creating(function ($model) {
            $model->tenant_id = request()->user()?->tenant->id;
        }); 
    }
}
