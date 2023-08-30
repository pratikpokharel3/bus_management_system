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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('departure_id')->nullable()->constrained('bus_departures')->nullOnDelete();
            $table->integer('total_tickets');
            $table->string('seats_booked');
            $table->integer('total_amount');
            $table->integer('vat');
            $table->integer('grand_total');
            $table->enum('booking_status', ['pending', 'accepted', 'rejected']);
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
