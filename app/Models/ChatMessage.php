<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'is_bot',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'is_bot' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
