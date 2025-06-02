<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'label',
        'capacity',
    ];

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
