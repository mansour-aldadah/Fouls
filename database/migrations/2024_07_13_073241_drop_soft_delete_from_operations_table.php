<?php

use App\Models\Operation;
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
        Schema::table('operations', function (Blueprint $table) {
            Operation::whereNotNull('deleted_at')->delete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations', function (Blueprint $table) {
            //
        });
    }
};
