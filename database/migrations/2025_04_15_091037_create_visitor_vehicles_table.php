<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visitor_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_registration_id')->constrained('visitor_registrations')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('plate_number');
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_vehicles');
    }
};