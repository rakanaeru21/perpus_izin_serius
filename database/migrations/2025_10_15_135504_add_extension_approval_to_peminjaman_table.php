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
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('extension_status', ['none', 'requested', 'approved', 'rejected'])->default('none')->after('status');
            $table->date('extension_requested_at')->nullable()->after('extension_status');
            $table->unsignedBigInteger('approved_by')->nullable()->after('extension_requested_at');
            $table->date('extension_approved_at')->nullable()->after('approved_by');
            $table->text('extension_reason')->nullable()->after('extension_approved_at');
            $table->text('rejection_reason')->nullable()->after('extension_reason');

            // Foreign key for approved_by (petugas/admin)
            $table->foreign('approved_by')->references('id_user')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'extension_status',
                'extension_requested_at',
                'approved_by',
                'extension_approved_at',
                'extension_reason',
                'rejection_reason'
            ]);
        });
    }
};
