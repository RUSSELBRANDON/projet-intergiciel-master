<?php

use App\Enums\BookStatusEnum;
use App\Enums\GenreEnum;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('author');
            $table->date('publication_date');
            $table->enum('genre', GenreEnum::toArray())->default(GenreEnum::NOVEL->value);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', BookStatusEnum::toArray())->default(BookStatusEnum::AVAILABLE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
