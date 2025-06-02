<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubject extends Model
{
    protected $fillable = [
        'classroom_id',
        'subject_id',
        'coef',
    ];
}
