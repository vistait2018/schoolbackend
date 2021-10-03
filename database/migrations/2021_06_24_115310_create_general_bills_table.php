<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_bills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount');
            $table->string('description');
            $table->tinyInteger('type')->unsigned()->default(\App\Enums\BillType::GeneralBill);
             $table->integer('school_class_id')->unsigned()->nullable();

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
        Schema::dropIfExists('general_bills');
    }
}
