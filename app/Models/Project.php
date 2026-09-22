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

    protected $casts = [
        'created_at' => 'datetime'
    ];
    #[Override]
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->tenant_id = request()->user()?->getTenant()?->id;
        }); 
    }


    public function members()
    {
        return $this->hasMany(Member::class,'tenant_id','tenant_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'project_id','id');
    }
}
