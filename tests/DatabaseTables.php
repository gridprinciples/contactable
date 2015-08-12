<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\Tests\Cases\DatabaseTestCase;
use Illuminate\Support\Facades\Schema;

class DatabaseTables extends DatabaseTestCase
{
    /**
     * Ensures the migrations ran and tables exist in the database.
     */
    public function test_tables_exist()
    {
        foreach ([
                     'users',
                     'password_resets',
                     'email_addresses',
                     'phone_numbers',
                 ] as $table) {
            $this->assertTrue(Schema::hasTable($table));
        }
    }

}
