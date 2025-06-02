<?php

namespace App\Http\Controllers\Usecases\Borrow;

use App\Enums\BookStatusEnum;
use App\Enums\EmailTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowRequest\CreateLoanRequest;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;

class BorrowController extends Controller
{

    public function getAllBorrows(){
        $borrows = Borrow::all();
        return response()->json($borrows);
    }
    public function createLoan(CreateLoanRequest $request, User $borrower, Book $book){

        $validatedData = $request->validated();
        if ($book->status === BookStatusEnum::BORROWED->value){
            return response()->json(['message'=>'livre indisponible ']);
        }
        $validatedData['borrower_id'] = $borrower->id;
        $validatedData['borrow_date'] =  now()->format('Y-m-d');
        $validatedData['book_id'] = $book->id;
        $loanRequest = Borrow::create($validatedData);
        $book->status = BookStatusEnum::BORROWED->value;
        $book->save();
        return response()->json($loanRequest);
    }

    public function updateLoan(CreateLoanRequest $request, Borrow $borrow){
        $validatedData = $request->validated();
        $borrow->lender_id = $validatedData['lender_id'];
        $borrow->due_date = $validatedData['due_date'];
        $borrow->save();
        return response()->json($borrow);
    }


    public function terminateALoan(Borrow $borrow, ServiceCommunicatorInterface $communicator){
           // Marquer l'emprunt comme terminé
        $borrow->return_date = now();
        $borrow->save();
    
        // Mettre à jour le statut du livre à "disponible"
        $book = $borrow->book;
        $book->status = BookStatusEnum::AVAILABLE->value;
        $book->save();
    
        // Récupérer les demandes en attente pour ce livre
        $pendingRequests = BorrowingRequest::where('book_id', $book->id)
                                        ->where('status', 'pending')
                                        ->with('requester')
                                        ->get();
    
        // Envoyer une notification à chaque utilisateur concerné
        foreach ($pendingRequests as $request) {
            $notificationData = [
                'type' => EmailTypeEnum::EMAILBOOKAVAILABLE->value,
                'data' => [
                    'bookTitle' => $book->title,
                    'requesterName' => $request->requester->username,
                    'to' => $request->requester->email,
                ]
            ];
    
            // Appel au service de notification
            $response = $communicator->call(
                service: 'NOTIFICATION-service',
                method: 'post',
                endpoint: '/api/notification/send',
                data: $notificationData,
                headers: []
            );
    
            if ($response->successful()) {
                Log::info('Notification envoyée à ' . $request->requester->email);
            } else {
                Log::error('Échec de l\'envoi de la notification pour la demande ID ' . $request->id);
            }
        }
    
        return response()->json(['message' => 'Livre retourné avec succès']);

    }

    public function deleteLoan(Borrow $borrow){
        $borrow->delete();
        $book = Book::where('id',$borrow->book_id)->first();
        $book->status = BookStatusEnum::AVAILABLE->value;
        $book->save();
        return response()->noContent();
    }
}
