<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'label',
    ];

    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function classrooms(){
        return $this->belongsToMany(Classroom::class);
    }
}
