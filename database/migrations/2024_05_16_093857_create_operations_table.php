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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_consumer_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 8, 2);
            $table->string('description')->nullable();
            $table->enum('type', ['صرف', 'وارد']);
            $table->enum('foulType', ['سولار', 'بنزين']);
            $table->string('receiverName')->nullable();
            $table->string('dischangeNumber', 4)->unique()->nullable();
            $table->date('date')->default(now());
            $table->boolean('checked')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
