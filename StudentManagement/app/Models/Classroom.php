<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'label',
        'capacity'
    ];

    public function registers(){
        return $this->hasMany(Register::class);
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class);
    }

    public function cycle(){
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }
}
