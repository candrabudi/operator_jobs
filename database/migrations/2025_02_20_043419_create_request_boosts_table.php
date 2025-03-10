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
        Schema::create('request_boosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->bigInteger('social_media_platform_id');
            $table->bigInteger('social_media_engagement_id'); 
            $table->foreignId('request_posting_id')->nullable();
            $table->string('link_post')->nullable();
            $table->text('notes')->nullable();
            $table->text('comment')->nullable();
            $table->integer('like_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->enum('status', ['pending', 'process', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_boosts');
    }
};
