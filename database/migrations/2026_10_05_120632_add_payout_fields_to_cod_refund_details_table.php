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
        Schema::table('cod_refund_details', function (Blueprint $table) {

            // Workflow status: pending → processing → completed | failed
            $table->string('status', 30)->default('pending')->after('ifsc_code');

            // Cashfree Payout references
            $table->string('bene_id', 100)->nullable()->after('status');
            $table->string('transfer_id', 100)->nullable()->after('bene_id');
            $table->string('utr_number', 100)->nullable()->after('transfer_id');

            // Transfer metadata
            $table->string('payment_mode', 20)->nullable()->after('utr_number'); // imps / neft / rtgs / upi
            $table->decimal('refund_amount', 10, 2)->nullable()->after('payment_mode');

            // Audit / debugging
            $table->json('cashfree_response')->nullable()->after('refund_amount');
            $table->text('failure_reason')->nullable()->after('cashfree_response');

            // Completion tracking
            $table->timestamp('processed_at')->nullable()->after('failure_reason');
            $table->unsignedBigInteger('processed_by')->nullable()->after('processed_at');

            // Indexes for admin dashboards / reconciliation queries
            $table->index('status');
            $table->index('utr_number');
            $table->index('transfer_id');
            $table->index('bene_id');

            // FK to users (admin who processed it)
            $table->foreign('processed_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cod_refund_details', function (Blueprint $table) {

            // Drop FK first (required before dropping the column)
            $table->dropForeign(['processed_by']);

            // Drop indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['utr_number']);
            $table->dropIndex(['transfer_id']);
            $table->dropIndex(['bene_id']);

            // Drop columns (reverse order to be safe)
            $table->dropColumn([
                'processed_by',
                'processed_at',
                'failure_reason',
                'cashfree_response',
                'refund_amount',
                'payment_mode',
                'utr_number',
                'transfer_id',
                'bene_id',
                'status',
            ]);
        });
    }
};