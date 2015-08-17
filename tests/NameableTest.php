<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\Tests\Cases\TestCase;
use GridPrinciples\Party\Tests\Mocks\Album;

class NameableTest extends TestCase
{
    public function test_setting_name_actually_sets_alternate_field()
    {
        $album = new Album(['name' => 'A Thousand Suns']);

        $this->assertEquals('A Thousand Suns', $album->title);
    }

    public function test_alternate_field_retrievable_by_name()
    {
        $album = new Album(['title' => 'Hybrid Theory']);

        $this->assertEquals('Hybrid Theory', $album->name);
    }
}
