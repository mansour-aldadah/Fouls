<?php

use App\Models\SubConsumer;
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
        Schema::create('sub_consumers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumer_id')->constrained()->restrictOnDelete();
            $table->string('details')->unique();
            $table->string('description')->nullable();
            $table->boolean('hasRecord')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_consumers');
    }
};
