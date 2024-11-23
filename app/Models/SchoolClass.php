<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_class';
    protected $fillable = [
        'teacher_id',
        'full_class_name',
        'class_name',
        'grade'
    ];

    public function users()
    {
        return $this->hasMany(UserIndex::class, 'class_id');
    }
}
