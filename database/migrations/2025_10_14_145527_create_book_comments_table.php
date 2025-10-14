<?php

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
        Schema::create('book_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_user');
            $table->tinyInteger('rating')->unsigned()->comment('Rating 1-5');
            $table->text('comment');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            // Index for better performance
            $table->index(['id_buku', 'created_at']);
            $table->index('id_user');

            // Ensure one comment per user per book
            $table->unique(['id_buku', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_comments');
    }
};
