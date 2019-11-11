<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

class DashboardTest extends DuskTestCase
{
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
    public function testCharts()
    {
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
                    ->assertVisible('#lowInventory')
                    ->assertVisible('#inventoryChart')
                    ->assertVisible('#recentInventory')
                    ->assertVisible('#viewSelect')
                    ->assertVisible('#monthlyChart')
                    ->assertVisible('#capacityChart')
        });
    }
}
