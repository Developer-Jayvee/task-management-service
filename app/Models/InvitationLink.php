<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class InvitationLink extends Model
{
    use SoftDeletes;
    
    CONST EXPIRATION_TIME  = 30;
    protected $table = "invitation_links";

    protected $fillable = [
        'code',
        'user_id',
        'tenant_id',
        'link',
        'is_accepted',
        'expiration_date'
    ];


    protected $casts = [
        'is_accepted' => 'boolean'
    ];

    #[Override]
    public static function booted()
    {
        static::creating( function ($model) {
            $model->expiration_date = Carbon::now()->addMinutes(30);
        });
    }

    public function isExpired(): bool
    {
        $to = Carbon::createFromFormat('Y-m-d H:i:s',$this->expiration_date);
        $today = Carbon::now();

        $diffInMinutes = $to->diffInMinutes($today);
        
        return $diffInMinutes >= self::EXPIRATION_TIME;
    }
}
