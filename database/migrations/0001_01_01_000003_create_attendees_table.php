<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('registered'); // Add this line
            $table->timestamp('attended_at')->nullable();   // Optional: for tracking attendance
            $table->timestamps();

            $table->unique(['user_id', 'event_id']); // Prevent duplicate registrations
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendees');
    }
};
