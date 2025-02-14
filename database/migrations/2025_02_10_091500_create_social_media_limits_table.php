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
        Schema::create('social_media_limits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('social_media_platform_id');
            $table->enum('platform_type', ['subscribe', 'follow', 'like', 'comment', 'share', 'repost', 'view']);
            $table->integer('min')->default(0);
            $table->integer('max')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_limits');
    }
};
