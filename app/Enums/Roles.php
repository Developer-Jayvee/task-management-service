<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = "admin";
    case  OWNER = "owner";
    case MEMBER = "member";

    
}
