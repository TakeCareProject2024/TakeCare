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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('CustomerFirstName');
            $table->string('CustomerLastName');
            $table->string('CustomerPhone');
            $table->string('CustomerEmail');
            $table->date('OrderDate');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('EmployeeNumber');
            $table->integer('Evalute');
            $table->enum('OrderState',['pending', 'processing', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
