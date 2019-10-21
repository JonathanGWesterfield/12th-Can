<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;

class SidebarTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSidebar()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History');
                    /*Once sidebar links become active
                    ->clickLink('Add Item Page')
                    ->clickLink('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->clickLink('Modify Items')
                    ->clickLink('Dashboard')
                    ->clickLink('History');
                    */
        });
    }
}
