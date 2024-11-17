<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'class_id',
        'fname',
        'lname',
        'email',
        'password',
        'image',
        'status',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'incoming_msg_id', 'user_id');
    }
}
