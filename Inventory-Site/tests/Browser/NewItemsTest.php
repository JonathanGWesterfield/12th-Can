<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NewItemsTest extends DuskTestCase
{public function testAddNewItem()
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
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        }); 
    }
    public function testAddNewItem1()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskFoodItem')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#foodItem')
                    ->press('submitModal')
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
        }); 
    }
    public function testAddNewItem2()
    {
        $this->browse(function ($browser) {
            $browser->visit('/new_items')
                    ->assertSee('Add Item Page')
                    ->press('#addItemButton')
                    ->waitForText('Add New Item')
                    ->type('#itemName', 'duskRefrigeration')
                    ->type('#capacity', 10)
                    ->type('#threshold', 50)
                    ->check('#refrigeration')
                    ->press('submitModal')
                    ->pause('1000')
                    ->press('submitItem')
                    ->waitForText('Confirmation')
                    ->press('saveChanges')
                    ->waitForText('successfully created');
                    
        }); 
    }
}
