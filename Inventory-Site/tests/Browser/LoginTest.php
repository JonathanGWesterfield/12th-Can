<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testMakeAccounts()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
            Need to logout the user once the account is created, probably need to look at dropdown menu in dusk documentation
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
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Apple')
                    ->type('email', 'johnapple@aol.com')
                    ->type('phone', '3143563413')
                    ->type('password', 'password1')
                    ->type('password_confirmation', 'password1')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Bpple')
                    ->type('email', 'johnbpple@aol.com')
                    ->type('phone', '3143563414')
                    ->type('password', 'password2')
                    ->type('password_confirmation', 'password2')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Cpple')
                    ->type('email', 'johncpple@aol.com')
                    ->type('phone', '3143563415')
                    ->type('password', 'password3')
                    ->type('password_confirmation', 'password3')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Dpple')
                    ->type('email', 'johndpple@aol.com')
                    ->type('phone', '3143563416')
                    ->type('password', 'password4')
                    ->type('password_confirmation', 'password4')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Epple')
                    ->type('email', 'johnepple@aol.com')
                    ->type('phone', '3143563417')
                    ->type('password', 'password5')
                    ->type('password_confirmation', 'password5')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Fpple')
                    ->type('email', 'johnfpple@aol.com')
                    ->type('phone', '3143563418')
                    ->type('password', 'password6')
                    ->type('password_confirmation', 'password6')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page')
                    ->type('name', 'John Gpple')
                    ->type('email', 'johngpple@aol.com')
                    ->type('phone', '3143563419')
                    ->type('password', 'password7')
                    ->type('password_confirmation', 'password7')
                    ->press('Register')
                    ->AssertSee('Inventory Dashboard Page');
        });
    }
}
