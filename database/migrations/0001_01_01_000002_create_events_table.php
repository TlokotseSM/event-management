<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->string('location');
                $table->integer('capacity');
                $table->decimal('price', 8, 2);

                $table->foreignId('user_id')
                      ->constrained()
                      ->onDelete('cascade');

                $table->unsignedBigInteger('category_id')->nullable();
                $table->timestamps();
            });

            // Add foreign key separately
            Schema::table('events', function (Blueprint $table) {
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('events');
    }
};
