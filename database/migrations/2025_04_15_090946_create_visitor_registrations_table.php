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
        Schema::create('visitor_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('id_type');
            $table->string('id_picture');
            $table->text('purpose');
            $table->text('message')->nullable();
            $table->boolean('is_group')->default(false);
            $table->integer('group_size')->nullable();
            $table->date('visit_date');
            $table->string('visit_time');
            $table->string('contact_person');
            $table->string('office');
            $table->boolean('has_vehicle')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('visitor_registrations');
    }
};