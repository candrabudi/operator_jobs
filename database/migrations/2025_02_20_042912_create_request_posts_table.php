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
        Schema::create('request_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('social_media_platform_id');
            $table->bigInteger('topic_id');
            $table->string('title');
            $table->string('notes')->nullable();
            $table->text('content');
            $table->enum('status', ['pending', 'process', 'completed'])->default('pending');
            $table->foreignId('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_posts');
    }
};
