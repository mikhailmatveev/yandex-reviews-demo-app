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
        Schema::table('integrations', function (Blueprint $table) {
            $table->enum('sync_status', [
                'idle',
                'syncing',
                'success',
                'error'
            ])->default('idle');

            $table->integer('sync_progress')->default(0);
            $table->text('sync_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('integrations', function (Blueprint $table) {
            $table->dropColumn('sync_status');
            $table->dropColumn('sync_progress');
            $table->dropColumn('sync_error');
        });
    }
};
