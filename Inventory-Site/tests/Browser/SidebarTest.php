<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SidebarTest extends DuskTestCase
{
    public function testSidebarAddInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/add_inventory')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
    public function testSidebarRemoveInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/remove_inventory')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
    public function testSidebarAddNewInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
    public function testSidebarModifyItems()
    {
        $this->browse(function ($browser) {
            $browser->visit('/modify_items')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
    public function testSidebarDashboard()
    {
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
    public function testSidebarHistory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->click('@hamburgerButton')
                    ->assertSee('Add Inventory')
                    ->assertSee('Remove Inventory')
                    ->assertSee('Add New Items')
                    ->assertSee('Modify Items')
                    ->assertSee('Dashboard')
                    ->assertSee('History')
                    ->clickLink('Add Inventory')
                    ->assertSee('Add Inventory')
                    ->clickLink('Remove Inventory')
                    ->assertSee('Remove Inventory')
                    ->clickLink('Add New Items')
                    ->assertSee('Add New Items')
                    ->clickLink('Modify Items')
                    ->assertSee('Modify Items')
                    ->clickLink('Dashboard')
                    ->assertSee('Dashboard')
                    ->clickLink('History')
        });
    }
}
