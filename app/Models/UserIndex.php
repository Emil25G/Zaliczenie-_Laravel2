<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIndex extends Model
{
    use HasFactory;

    protected $table = 'users_index';

    protected $fillable = ['class_id', 'index', 'status'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
