<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{

    protected $table = 'years';
    
    protected $fillable = [
        'school_year',
    ];

    public function registers(){
        return $this->hasMany(Register::class);
    }
}
