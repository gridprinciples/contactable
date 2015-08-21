<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConnectionsTable extends Migration {

	public function up()
	{
		Schema::create('connections', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->bigInteger('party_id')->unsigned()->index();
			$table->bigInteger('other_party_id')->unsigned()->index();

			$table->string('name')->nullable(); // party_id's title.  "Party names Other Party"
			$table->string('other_name')->nullable(); // other_party_id's title. "Other Party names Party"

			$table->date('start')->nullable(); // When did this relationship begin?
			$table->date('end')->nullable(); // When did this relationship end?
		});
	}

	public function down()
	{
		Schema::drop('connections');
	}
}
