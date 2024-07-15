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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('EventName', 60);
            $table->string('EventType',50);
            $table->text('Location');
            $table->string('EventSchedule', 50);
            $table->text('Description');
            $table->text('UrlImage');
            $table->date('EventDate');
            $table->string('Assistants', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
