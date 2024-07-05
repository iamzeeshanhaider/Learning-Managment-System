<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;  

    protected $fillable=[
        'sender_id',
        'receiver_id',
        'chat_id',
        'last_time_message',
    ];

    //relationships

    public function messages( )
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function user( )
    {
        return $this->belongsTo(User::class);
    }

    public function sender( )
    {
        return $this->belongsTo(User::class ,'sender_id');
    }

    public function receiver( )
    {
        return $this->belongsTo(User::class ,'receiver_id');
    }


    public function chat( )
    {
        return $this->belongsTo(Chat::class ,'chat_id');
    }

    

}


