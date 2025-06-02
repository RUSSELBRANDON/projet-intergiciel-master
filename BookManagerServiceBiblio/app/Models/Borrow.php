<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'borrow_date',
        'due_date',
        'return_date',
        'borrower_id',
        'lender_id',
        'book_id',
    ];


    public function lender(){
        return $this->belongsTo(User::class,'lender_id');
    }

    public function borrower(){
        return $this->belongsTo(User::class,'borrower_id');
    }

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }
}
