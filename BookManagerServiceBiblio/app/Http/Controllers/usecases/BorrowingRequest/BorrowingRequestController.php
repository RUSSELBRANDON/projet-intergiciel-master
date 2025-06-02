<?php

namespace App\Http\Controllers\Usecases\BorrowingRequest;

use App\Enums\BorrowingRequestStatusEnum;
use App\Enums\EmailTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BorrowingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;

class BorrowingRequestController extends Controller
{
    public function makeLoanRequest(Request $request, Book $book, User $requester, ServiceCommunicatorInterface $communicator)
    {
        $bookOwner = $book->user; 
        $currentUser = $request->current_user ?? $request->session()->get('user');
    
        $borrowingData = [
            'request_date' => now()->format('d-m-Y'),
            'status' => BorrowingRequestStatusEnum::PENDING->value,
            'book_id' => $book->id,
            'requester_id' => $requester->id,
        ];
    
        $notificationData = [
            'type' => EmailTypeEnum::EMAILLOANREQUEST->value,
            'data' => [
                'userName' => $bookOwner->username,
                'bookTitle' => $book->title,
                'requestDate' => $borrowingData['request_date'],
                'borrowerName' => $currentUser['username'],
                'to' => $bookOwner->email,
            ]
        ];

        DB::beginTransaction();
        try {
            // Création de la demande
            $borrowingRequest = BorrowingRequest::create($borrowingData);
    
            // Envoi de la notification
            $response = $communicator->call(
                service: 'NOTIFICATION-service',
                method: 'post',
                endpoint: '/api/notification/send',
                data: $notificationData,
                headers: []
            );
    
            if (!$response->successful()) {
                throw new \Exception("Échec de l'envoi de la notification: " . $response->status());
            }
    
            DB::commit();
            
            return response()->json([
                'message' => 'Demande créée avec succès',
                'borrowing_request' => $borrowingRequest
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();            
            return response()->json([
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function replyForRequest(Request $request, User $owner, BorrowingRequest $borrowingRequest, ServiceCommunicatorInterface $communicator){
        $validator = Validator::make($request->all(), ['status'=>'required|in:approved,rejected']);
        if($validator->fails()){ return response()->json(['message'=>$validator->errors()]);}

        if ($borrowingRequest->status !== BorrowingRequestStatusEnum::PENDING->value){
            return response()->json(['message'=>"requete deja traitee"]);
        }else{
            $book= Book::where('id', $borrowingRequest->book_id)->firstOrFail();
            $borrower = User::where('id', $borrowingRequest->requester_id)->firstOrFail();


            $notificationData = [
                'type' => EmailTypeEnum::EMAILLOANREPLY->value,
                'data' => [
                    'ownerName'=> $owner->username,
                    'ownerEmail'=> $owner->email,
                    'status' => $request->status,
                    'bookTitle' => $book->title,
                    'borrowerName' => $borrower->username,
                    'to' => $borrower->email,
                ]
            ];

            $response = $communicator->call(
                service: 'NOTIFICATION-service',
                method: 'post',
                endpoint: '/api/notification/send',
                data: $notificationData,
                headers: []
            );

            if (!$response->successful()) {
                throw new \Exception("Échec de l'envoi de la notification: " . $response->status());
            }
            $borrowingRequest->status = $request->status;
            $borrowingRequest->save();

            return response()->json(["message"=>"requete traitee avec succes"]);

        }


    }

    }

