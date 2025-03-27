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
            $table->id();
            $table->string('serial')->unique();
            $table->string('transaction_id');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('total_outstanding_amount', 15, 2);
            $table->string('status');
            $table->dateTime('repayment_due_date');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->timestamps();
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
