<?php

namespace App\Traits;

trait NotificationFormatTrait
{
    public function notificationFormat(string $title, string $message , int $id , string $type)
    {
        return [
            'type' => $type,
            'id' => $id,
            'title' => $title,
            'message' => $message,
        ];
    }
}
