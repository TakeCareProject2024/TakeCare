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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('companyName');
            $table->string('description');
            $table->text('services');
            $table->string('Email')->unique();
            $table->string('whatsAppLink')->nullable();
            $table->string('instagramLink')->nullable();
            $table->string('phone1');
            $table->string('phone2');
            $table->string('Address');
            $table->decimal('Lat', 10, 6);  
            $table->decimal('Lang', 10, 6); 
            $table->string('password');
            $table->text('comments'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
