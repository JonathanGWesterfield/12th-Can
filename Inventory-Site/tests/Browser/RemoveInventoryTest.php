<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RemoveInventoryTest extends DuskTestCase
{
    /**
     * Put in group 'site'
     *
     * @group site
     */
    //login to the website
    public function testLogin()
    {
        $this->browse(function ($browser) {
            //fill in the credentials and login
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', 'johnsmith@aol.com')
                    ->type('password', 'password')
                    ->press('Login');
        });
    }
    //add an item to ensure one item exists
    public function testAddNewItem()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskFoodItem&Refrigeration')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#foodItem')
                    ->check('#refrigeration')
                    ->press('submitModal')
                    ->pause('1000') //pause/wait for 1000ms for the modal to disappear
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        }); 
    }
    //Remove inventory for the first item 
    public function testRemoveInventory()
    {
        $this->browse(function ($browser) {
            $browser->visit('/remove_inventory')
                    ->assertSee('Remove Inventory Page')
                    ->press('#item-0')
                    ->type('quantity', 10)
                    ->type('comment', 'comment1')
                    ->press('submit')
                    //wait for confirmation modal
                    ->waitForText('Confirmation')
                    ->assertSee('10')
                    ->assertSee('comment1')
                    ->press('saveChanges')
                    ->waitForText('Inventory was removed');
        });
    }
}
