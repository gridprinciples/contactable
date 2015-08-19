<?php

namespace GridPrinciples\Contactable\Tests;

use GridPrinciples\Contactable\Tests\Cases\DatabaseTestCase;
use Illuminate\Support\Facades\Schema;

class DatabaseTables extends DatabaseTestCase
{
    /**
     * Ensures the migrations ran and tables exist in the database.
     */
    public function test_tables_exist()
    {
        $expectedTables = [
            'users',
            'password_resets',
            'email_addresses',
            'phone_numbers',
            'addresses',
        ];

        foreach ($expectedTables as $table) {
            $this->assertTrue(Schema::hasTable($table));
        }
    }
}
