<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'sender_id',
        'email',
        'phone_number',
        'message',
        'buyer_name',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
