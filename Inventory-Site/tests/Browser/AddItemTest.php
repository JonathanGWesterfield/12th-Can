<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddItemTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('password', 'password')
                    ->press('Login');
        });
    }

    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add');
        });
    }
}
