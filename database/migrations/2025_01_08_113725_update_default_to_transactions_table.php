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
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->decimal('fine', 8, 2)->nullable()->change();  // Make fine nullable
            $table->date('borrwed_at')->nullable()->change();  // Make borrowed_at nullable
            $table->date('returned_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->dropColumn('fine');
            $table->dropColumn('borrwed_at');
            $table->dropColumn('returned_at');
        });
    }
};
