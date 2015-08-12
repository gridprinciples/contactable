<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartiesTable extends Migration {

	public function up()
	{
		Schema::create('parties', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->string('name_legal')->nullable();
			$table->string('name_short', 16);
			$table->string('type')->nullable();

			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('parties');
	}
}
