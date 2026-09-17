<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = "tenant";

    protected $fillable = [
        'name',
        'slug',
        'plan'
    ];

    public function scopeTenant($query , string $slug)
    {
        return $query->where('slug',$slug);
    }
}
