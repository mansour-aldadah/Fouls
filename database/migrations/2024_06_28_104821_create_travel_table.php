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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->foreignid('sub_consumer_id')->constrained()->restrictOnDelete();
            $table->string('road');
            $table->string('cause');
            $table->date('date');
            $table->enum('status', ['منشأة', 'قيد التنفيذ', 'منتهية', 'ملغية'])->default('منشأة');
            $table->string('recordBefore')->nullable();
            $table->string('recordAfter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
