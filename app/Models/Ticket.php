<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Scopes\TenantScope;
use App\Models\Scopes\TicketScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'tenant_id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assignee_id',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
    ];

    #[Override]
    public static function booted()
    {
        // parent::boot();
        static::creating(function ($model) {
            $user = request()->user();
            $model->created_by = $user->id;
            $model->tenant_id = $user?->getTenant()->id;
        });
        static::addGlobalScope(new TenantScope);
        static::addGlobalScope(new TicketScope);
    }

    public function tenant(Builder $query)
    {
        $query->where(
            'tenant_id', request()->user()?->getTenant()->id
        );
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }
}
