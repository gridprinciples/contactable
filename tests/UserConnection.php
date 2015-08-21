<?php namespace GridPrinciples\Contactable\Tests;

use GridPrinciples\Contactable\Tests\Cases\UserTestCase;
use GridPrinciples\Contactable\Tests\Mocks\User;

class UserConnection extends UserTestCase
{
    public function test_users_can_be_connected()
    {
        $captain = $this->createUser([
            'name' => 'Jean-luc Picard',
        ]);

        $first_officer = $this->createUser([
            'name' => 'William Riker',
        ]);

        $captain->connect($first_officer);

        $this->assertContains('William Riker', $captain->connections->lists('name'));
        $this->assertContains('Jean-luc Picard', $first_officer->connections->lists('name'));
    }

    public function test_user_connections_can_hold_title()
    {
        $kid = $this->createUser([
            'name' => 'Greg',
        ]);

        $parent = $this->createUser([
            'name' => 'Robert',
        ]);

        $parent->connect($kid, [
            'name' => 'Dad',
            'other_name' => 'Son',
        ]);

        $this->assertContains('Son', $kid->connections->lists('pivot.name'));
        $this->assertContains('Dad', $kid->connections->lists('pivot.other_name'));

        $this->assertContains('Dad', $parent->connections->lists('pivot.name'));
        $this->assertContains('Son', $parent->connections->lists('pivot.other_name'));
    }

    public function test_active_user_connections()
    {
        $band = $this->createUser([
            'name' => 'Pink Floyd',
        ]);

        $bassist = $this->createUser([
            'name' => 'Roger Waters',
        ]);

        $drummer = $this->createUser([
            'name' => 'Nick Mason',
        ]);

        $guitarist = $this->createUser([
            'name' => 'David Gilmour',
        ]);

        $singer = $this->createUser([
            'name' => 'Syd Barrett',
        ]);

        $band->connect($drummer);
        $band->connect($bassist, [
            'start' => '08-01-1967',
            'end' => '01-01-2025',
        ]);
        $band->connect($guitarist, [
            'start' => '12-01-1967',
            'end' => '07-02-2005',
        ]);
        $band->connect($singer, [
            'end' => '01-01-1968',
        ]);

        $activeMembers = $band->active_connections->lists('name');

        $this->assertContains('Nick Mason', $activeMembers);
        $this->assertContains('Roger Waters', $activeMembers);
        $this->assertNotContains('Syd Barrett', $activeMembers);
        $this->assertNotContains('David Gilmour', $activeMembers);
    }
}
