<?php

namespace App\Http\Controllers\Usecases\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getAllBooks(User $user){
        $userbooks = $user->books()->paginate(10);
        return response()->json($userbooks);
    }
}
