<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateAccount extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    //ensure correct fields
                    ->assertSee('Name')
                    ->assertSee('E-Mail Address')
                    ->assertSee('Phone')
                    ->assertSee('Password')
                    ->assertSee('Confirm Password') 
                    //looks for the name tag in register.blade.php. ex: <... name='name' ...> 
                    ->type('name', 'John Smith')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('phone', '3143563412')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page');
        });
    }
}
