<?php

namespace App\Http\Controllers\Ressources\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequests\CreateBookRequest;
use App\Http\Requests\BookRequests\UpdateBookRequest;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookRequest $request)
    {
        $validatedData = $request->validated();
        $user = $request->current_user ?? $request->session()->get('user');    
        $validatedData['owner_id'] = $user['id'];
        $book = Book::create($validatedData);
        return response()->json($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return  response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->publication_date = $validatedData['publication_date'];
        $book->genre = $validatedData['genre'];
        $book->status = $validatedData['status'];
        $book->save();
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
