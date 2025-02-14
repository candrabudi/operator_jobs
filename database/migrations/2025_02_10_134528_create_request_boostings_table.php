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
        Schema::create('request_boostings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('social_media_platform_id');
            $table->bigInteger('social_media_platform_limit_id');
            $table->string('trx_boost');
            $table->string('link_post');
            $table->text('notes');
            $table->text('comment')->nullable();
            $table->integer('qty');
            $table->enum('status', ['pending', 'process', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_boostings');
    }
};
