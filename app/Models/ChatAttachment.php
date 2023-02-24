<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    use HasFactory;

    public $fillable = [
        'task_chat_id',
        'original_name',
        'extention',
        'attachment'
    ];
}
