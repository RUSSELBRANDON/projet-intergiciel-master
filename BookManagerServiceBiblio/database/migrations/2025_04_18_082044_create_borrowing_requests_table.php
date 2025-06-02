<?php

use App\Enums\BorrowingRequestStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowing_requests', function (Blueprint $table) {
            $table->id();
            $table->date('request_date');
            $table->enum('status', BorrowingRequestStatusEnum::toArray())->default(BorrowingRequestStatusEnum::PENDING->value);
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('book_id')->constrained('books');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_requests');
    }
};
