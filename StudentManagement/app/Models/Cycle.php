<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $fillable = [
        'label',
    ];

    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }
}
