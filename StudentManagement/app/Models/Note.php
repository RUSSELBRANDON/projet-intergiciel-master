<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;
use App\Models\Exam;



class Note extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'subject_id',
        'note',
    ];

    public function subject(){
        return $this->belongsTo(Subject::Class, 'subject_id');
    }

    public function exam(){
        return $this->belongsTo(Exam::Class, 'exam_id');
    }

    public function user(){
        return $this->belongsTo(User::Class, 'user_id');
    }
}
