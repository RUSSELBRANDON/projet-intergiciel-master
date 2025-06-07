<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom;

class Subject extends Model
{
    protected $fillable = [
        'label',
    ];
    public function teacher(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
