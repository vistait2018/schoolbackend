<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->integer('general_bill_id')->unsigned();
            $table->string('general_bill_name')->unsigned();
            $table->float('general_bill_amount')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->unsignedBigInteger('school_session_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('term_id');
            $table->integer('quantity')->unsigned();
            $table->boolean('isChecked')->default(false);
            $table->boolean('collected')->default(false);
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
        Schema::dropIfExists('debts');
    }
}
