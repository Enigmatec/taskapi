<?php

namespace App;

enum TaskStatusEnum: string
{
    case PENDING = "pending";
    case PROGRESS = "progress";
    case COMPLETED = "completed";  
}
