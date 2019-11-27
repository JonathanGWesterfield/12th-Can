<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HistoryTest extends DuskTestCase
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
    public function testTable()
    {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->assertVisible('#item')
                    ->assertVisible('#change')
                    ->assertVisible('#comment')
                    ->assertVisible('#vtransactionDate');
        });
    }
    public function testAscendingName() {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->select('Sort Type', 'Alpabetical')
                    ->select('Ordering', 'Ascending')
                      ->press('submitButton');
                      }
        
    }
}
