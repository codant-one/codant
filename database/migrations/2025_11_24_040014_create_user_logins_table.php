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
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('device')->comment('Client Device type: Tablet, Smartphone, Desktop');
            $table->string('plataform')->comment('Client Device plataform: Linux, Windows, Mac');
            $table->string('browser')->comment('Client Device Browser: Chrome, Firefox, Opera');
            $table->boolean('is_bot')->comment('Client is a Bot: true or false');
            $table->string('ip')->comment('Client IP Address');
            $table->string('location')->comment('Client location');
            $table->string('session_id')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logins');
    }
};
