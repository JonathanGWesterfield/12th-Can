<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ModifyItemTest extends DuskTestCase
{
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
   //Modify inventory for the first item 
   public function testModifyInventory()
   {
       $this->browse(function ($browser) {
           $browser->visit('/modify_items')
                   ->assertSee('Modify Items Page')
                   ->press('#item-0')
                   ->type('#itemName', 'testRename')
                   ->type('#capacity', 10)
                   ->type('#threshold', 100)
                   ->check('#foodItem')
                   ->check('#refrigeration')
                   ->check('#delete')
                   ->press('submitItem')
                   //wait for confirmation modal
                   ->waitForText('Confirmation')
                   ->assertSee('testRename')
                   ->assertSee('10')
                   ->assertSee('100')
                   ->press('saveChanges')
                   ->waitForText('successfully modified.');
       });
   }
}
