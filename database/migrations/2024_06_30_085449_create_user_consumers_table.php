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
        Schema::create('user_consumers', function (Blueprint $table) {

            $table->timestamps();
            $table->foreignid('user_id')->constrained()->restrictOnDelete();
            $table->foreignid('consumer_id')->constrained()->restrictOnDelete();
            $table->primary(['user_id', 'consumer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_consumers');
    }
};
