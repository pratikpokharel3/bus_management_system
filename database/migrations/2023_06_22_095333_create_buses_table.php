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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('bus_name');
            $table->integer('total_seats');
            $table->string('bus_plate_number')->unique();
            $table->string('driver_name');
            $table->string('conductor_name');
            $table->string('bus_owner');
            $table->foreignId('bus_route_id')->nullable()->constrained('buses')->nullOnDelete();
            $table->enum('bus_status', ['available', 'not_available']);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
