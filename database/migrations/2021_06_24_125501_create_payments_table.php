<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned();
            $table->unsignedBigInteger('school_session_id');
            $table->unsignedBigInteger('term_id');
            $table->integer('general_bills_id')->unsigned();
            $table->string('paid_for')->unsigned();
            $table->string('transaction_id');
            $table->string('receipt_date');
            $table->string('receipt_no');
            $table->string('payment_options');
            $table->string('paid_by');
            $table->integer('user_id');
            $table->decimal('amount_to_pay',8,2,true);
            $table->decimal('amount_paid');
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
        Schema::dropIfExists('payments');
    }
}
