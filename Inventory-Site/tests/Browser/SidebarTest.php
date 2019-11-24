<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SidebarTest extends DuskTestCase
{
    /**
     * Put in group 'site'
     *
     * @group site
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
    public function testSidebarAddInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/add_inventory')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarRemoveInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/remove_inventory')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarAddNewInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarModifyItems()
    {
        $this->browse(function ($browser) {
            $browser->visit('/modify_items')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    public function testSidebarDashboard()
    {
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    /* Uncomment once History page exists
    public function testSidebarHistory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/history')
                    ->press('hamburgerButton')
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
                    ->AssertSee('Low Inventory')
                    ->AssertSee('Recent Inventory')
                    ->clickLink('History');
        });
    }
    */
}
