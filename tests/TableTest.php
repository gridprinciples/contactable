<?php

namespace GridPrinciples\Party\Tests;

use Illuminate\Support\Facades\Schema;

class TableTest extends DatabaseTestCase
{
    public function testTablesExist()
    {
        foreach ([
                     'email_addresses',
                     'phone_numbers',
                 ] as $table) {
            $this->assertTrue(Schema::hasTable($table));
        }
    }

}
