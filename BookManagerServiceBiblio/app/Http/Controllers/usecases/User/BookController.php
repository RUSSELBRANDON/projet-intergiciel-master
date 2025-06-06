<?php

namespace App\Http\Controllers\Usecases\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getAllBooks(User $user){
        $userbooks = $user->books;
        return response()->json($userbooks);
    }
}
