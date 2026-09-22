<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Override;

class Ticket extends Model
{
    protected $table = "tickets";

    protected $fillable = [
        'tenant_id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assignee_id',
        'due_date',
        'created_by'
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class
    ];


    #[Override]
    public static function boot()
    {
        parent::boot();
        static::creating( function ($model) {
            $model->created_by = request()->user()->id;
            $model->tenant_id = request()->user()?->tenant->id;
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
