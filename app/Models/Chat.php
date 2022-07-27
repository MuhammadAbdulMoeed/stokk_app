<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function firstUser()
    {
        return $this->belongsTo(User::class,'user_1');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class,'user_2');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class,'chat_id');
    }


}
