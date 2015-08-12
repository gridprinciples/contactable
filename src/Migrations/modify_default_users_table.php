<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ModifyDefaultUsersTable extends Migration
{
    public function up()
    {
        // Migration blocks are split because of weirdness with SQLite
        // See: https://github.com/laravel/framework/issues/2694

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('party_id')->unsigned()->index()->default('');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('party_id');
        });
    }
}
