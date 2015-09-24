<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

    public function up()
    {
        Schema::create('addresses', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('addressable_id')->unsigned()->index();
            $table->string('addressable_type');

            $table->string('street')->nullable();
            $table->string('street_extra')->nullable();
            $table->string('city')->nullable();
            $table->string('subdivision')->nullable();
            $table->string('country', 2)->nullable()->default('us');
            $table->string('postal_code')->nullable();

            $table->smallInteger('position')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('addresses');
    }
}
