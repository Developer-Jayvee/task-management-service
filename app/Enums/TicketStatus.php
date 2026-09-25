<?php

namespace App\Enums;

enum TicketStatus: string
{
    case TODO = "to-do";
    case ONGOING = "in-progress";
    case COMPLETED = "completed";
}
