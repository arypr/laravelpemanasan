<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_receivables', function (Blueprint $table) {
            $table->id(); // primary key, auto increment
            $table->string('receivable_id')->unique(); // receivable_id sebagai unique field
            $table->string('transaction_id'); // transaction_id
            $table->float('total_amount', 15, 2); // total_amount dalam bentuk float
            $table->float('total_outstanding_amount', 15, 2); // total_outstanding_amount dalam bentuk float
            $table->string('status'); // status
            $table->timestamp('repayment_due_date'); // repayment_due_date sebagai timestamp
            $table->timestamps(); // created_at dan updated_at otomatis
            $table->string('created_by'); // created_by
            $table->string('updated_by')->nullable(); // updated_by, nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_receivables');
    }
};
