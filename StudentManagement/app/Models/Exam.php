<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'label',
    ];

    public function notes(){
        return $this->hasMany(Note::class);
    }
}
