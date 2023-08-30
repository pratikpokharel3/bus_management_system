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
        Schema::create('bus_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->nullable()->constrained('buses')->nullOnDelete();
            $table->foreignId('bus_route_id')->nullable()->constrained('bus_routes')->nullOnDelete();
            $table->integer('total_tickets_booked')->default(0);
            $table->string('seats_booked')->nullable();
            $table->string('pending_seats')->nullable();
            $table->dateTime('departure_datetime');
            $table->enum('departure_status', ['not_started', 'pending', 'arrived', 'cancelled'])->default('not_started');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_departures');
    }
};
