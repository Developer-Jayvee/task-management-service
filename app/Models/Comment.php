<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'ticket_id',
        'content',
        'created_by',
        'updated_by'
    ];


    #[Override]
    public static function booted()
    {
        $user = request()->user();
        static::creating( function ($model) use($user) {
            $model->created_by = $user->id;
        });
    }
    public function ticket() 
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }
}   
