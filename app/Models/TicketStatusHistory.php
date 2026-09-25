<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Override;

class TicketStatusHistory extends Model
{
    protected $table = 'ticket_status_histories';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => TicketStatus::class
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = request()->user()->id;
        });
    }

}
