<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publication_date',
        'genre',
        'status',
        'owner_id'
    ];


    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    public function BorrowingRequests(){
        return $this->hasMany(BorrowingRequest::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'owner_id');
    }


}
