<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingRequest extends Model
{
    protected $fillable = [
        'request_date',
        'status',
        'requester_id',
        'book_id',
    ];

    public function requester(){
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }
}
