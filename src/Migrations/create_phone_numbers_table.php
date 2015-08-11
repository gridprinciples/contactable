<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhoneNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('number');
            $table->string('type', 64)->nullable()->default('work');
            $table->string('country', 2)->default('us');

            $table->bigInteger('phonable_id')->unsigned()->index();
            $table->string('phonable_type');
        });
    }

    public function down()
    {
        Schema::drop('phone_numbers');
    }
}
