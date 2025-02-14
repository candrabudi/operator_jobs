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
        Schema::create('request_posting_media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_posting_id');
            $table->string('file_path');
            $table->string('file_ext');
            $table->integer('file_size');
            $table->enum('file_type', ['image', 'video', 'doc']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_posting_media');
    }
};
