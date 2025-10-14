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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id')->default(2)->comment('1: Inactive. 2: Active');
            $table->double('max_month_amount', 10, 2)->comment("Maximun transfer amount by month");
            $table->string('iso')->nullable();
            $table->string('name');
            $table->string('nicename')->nullable();
            $table->string('iso3')->nullable();
            $table->integer('numcode')->nullable();
            $table->string('phonecode')->nullable();
            $table->unsignedSmallInteger('phone_digits')->default(0)->comment('Maximum number of phone digits');
            $table->string('flag')->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
