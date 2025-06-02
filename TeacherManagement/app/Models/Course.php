<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'day',
        'hour_start',
        'hour_end',
        'user_id',
        'subject_id',
        'classroom_id',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

}
