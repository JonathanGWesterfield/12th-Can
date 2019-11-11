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
                    ->assertSee('Add Item Page')
                    ->assertSee('Item')
                    ->assertSee('Capacity')
                    ->assertSee('Low Inventory Threshold')
                    ->assertSee('Food Item')
                    ->assertSee('Needs to be refrigerated')
                    ->assertSee('Remove Row?')
                    ->assertSee('Search')
                    ->assertSee('Available Items');
        });
    }

    public function testExample2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->click('#addItemBtn')
                    ->assertSee('Add New Item')
                    ->assertSee('Capacity')
                    ->assertSee('Threshold')
                    ->assertSee('Needs to be refrigerated')
                    ->type('itemName','Yeet Issa Test Item Hehe')
                    ->type('capacity','100')
                    ->type('threshold','30')
                    ->assertSee('Submit')
                    //->assertSee('Yeet Issa Test Item Hehe')
                    ->assertSee('100')
                    ->assertSee('30')
                    //->click('#modalSubmit')
                    ->assertDontSee('Add New Item')
                    ->click('#sub')
                    ;
                    
        });
    }

    public function testExample3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->assertSee('Item')
                    ->assertSee('Capacity')
                    ->assertSee('Low Inventory Threshold')
                    ->assertSee('Food Item')
                    ->assertSee('Needs to be refrigerated')
                    ->assertSee('Remove Row?')
                    ->assertSee('Search')
                    ->assertSee('Available Items');
        });
    }
}
