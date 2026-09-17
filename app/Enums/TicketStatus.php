<?php

namespace App\Enums;

enum TicketStatus: string
{
    case TODO = "to-do";
    case ONGOING = "on-going";
    case COMPLETED = "completed";
}
