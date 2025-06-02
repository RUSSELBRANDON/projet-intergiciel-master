<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'user_id', 
        'school-year_id',
        'classroom_id',
    ];

    public function student(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schoolYear(){
        return $this->belongsTo(Schoolyear::class, 'schoolyear_id');
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
