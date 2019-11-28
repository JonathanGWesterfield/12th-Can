<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminPanelTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function ($browser) {
            //fill in the credentials and login to admin account
            $browser->visit('/login')
                    ->assertSee('E-Mail')
                    ->assertSee('Password')
                    ->type('email', '12thcanNoReply@gmail.com')
                    ->type('password', 'BigBoss12345')
                    ->press('Login')
                    ->assertSee('Low Inventory');
        });
    }
    //Check admin panel content
    public function testCheckAdminPanel()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin_panel')
                    ->assertSee('Admin Panel');   
        });
    }
    //Accept pending account and ensure it is added to correct table
    public function testAcceptPendingAccount()
    {
        $this->browse(function ($browser) {
            $browser->press('pendingAccountsAccept')
                    ->waitForText('Accept Account')
                    ->press('acceptAccountSubmit')
                    ->waitForText('was successfully accepted')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('Big Boss')
                              ->assertSee('7132536097')
                              ->assertSee('bigboss@metalgear.com');
                    });
        });
    }
    //Reject pending account and ensure it was deleted
    public function testRejectPendingAccount()
    {
        $this->browse(function ($browser) {
            $browser->press('pendingAccountsReject')
                    ->waitForText('Reject Account')
                    ->press('rejectAccountSubmit')
                    //Uncomment once email is sent successfully from backend 
                    //->waitForText('was successfully rejected.')
                    ->assertSee('Admin Panel');
        });
    }
    //Test a successful account modification
    public function testCurrentAccountsModify()
    {
        $this->browse(function ($browser) {
            $browser->press('currentAccountsModify')
                    ->waitForText('Modify Account')
                    ->type('name', 'dusk')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '0000000000')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified.')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('dusk')
                              ->assertSee('0000000000')
                              ->assertSee('no@dusk.com');
                    });

        });
    } 
    //Test a failing account modification due to incorrect user input
    public function testCurrentAccountsModifyError()
    {
        $this->browse(function ($browser) {
            $browser->press('currentAccountsModify')
                    ->waitForText('Modify Account')
                    //Put a blank field in form
                    ->type('name', '')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '0000000000')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->type('name', 'test')
                    ->type('email', '')
                    ->type('phone', '0000000000')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    /*
                    ->type('name', 'test')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', 'abcdefghij')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    */
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->type('name', '')
                    ->type('email', '')
                    ->type('phone', '')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->press('closeModifyAccount')
                    ->waitForText('Admin Panel')
                    ->pause('500')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('dusk')
                              ->assertSee('0000000000')
                              ->assertSee('no@dusk.com');
                    });
        });
    }  
    //Test to see if account can be modified and archived
    public function testCurrentAccountsModify1()
    {
        $this->browse(function ($browser) {
            $browser->press('currentAccountsModify')
                    ->waitForText('Modify Account')
                    ->type('name', 'dusk')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '0000000000')
                    ->check('#accArchive')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified.')
                    ->with('@pastAccountsTable', function ($table) {
                        $table->assertSee('dusk')
                              ->assertSee('0000000000')
                              ->assertSee('no@dusk.com');
                    });

        });
    }
    public function testPastAccountsModify()
    {
        $this->browse(function ($browser) {
            $browser->press('pastAccountsModify')
                    ->waitForText('Modify Account')
                    ->type('name', 'duskdusk')
                    ->type('email', 'no@duskdusk.com')
                    ->type('phone', '1000000000')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified.')
                    ->with('@pastAccountsTable', function ($table) {
                        $table->assertSee('duskdusk')
                              ->assertSee('1000000000')
                              ->assertSee('no@duskdusk.com');
                    });

        });
    }
    public function testPastAccountsModifyError()
    {
        $this->browse(function ($browser) {
            $browser->press('pastAccountsModify')
                    ->waitForText('Modify Account')
                    //Put a blank field in form
                    ->type('name', '')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '0000000000')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->type('name', 'test')
                    ->type('email', '')
                    ->type('phone', '0000000000')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    /*
                    ->type('name', 'test')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', 'abcdefghij')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    */
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->type('name', '')
                    ->type('email', '')
                    ->type('phone', '')
                    ->press('modifyAccountSubmit')
                    ->assertSee('Modify Account')
                    ->press('closeModifyAccount')
                    ->waitForText('Admin Panel')
                    ->pause('500')
                    ->with('@pastAccountsTable', function ($table) {
                        $table->assertSee('duskdusk')
                              ->assertSee('1000000000')
                              ->assertSee('no@duskdusk.com');
                    });
        });
    } 
    public function testPastAccountsModify1()
    {
        $this->browse(function ($browser) {
            $browser->press('pastAccountsModify')
                    ->waitForText('Modify Account')
                    ->type('name', 'dusk')
                    ->type('email', 'no@dusk.com')
                    ->type('phone', '0000000000')
                    ->uncheck('#accArchive')
                    ->select('#positionDropdown')
                    ->press('modifyAccountSubmit')
                    ->waitForText('was successfully modified.')
                    ->with('@currentAccountsTable', function ($table) {
                        $table->assertSee('dusk')
                              ->assertSee('0000000000')
                              ->assertSee('no@dusk.com');
                    });
        });
    }
    public function testCurrentPositionsError()
    {
        $this->browse(function ($browser) {
            $browser->press('currentPositionsModify')
                    ->waitForText('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'no@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', '')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'no@dusk.com')
                    ->type('description', '')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'test')
                    ->type('description', '')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->press('modifyPositionClose')
                    ->assertSee('Admin Panel')
                    ->with('@currentPositionsTable', function ($table) {
                        $table->assertSee('Big Boss')
                              ->assertSee('jgwesterfield@gmail.com')
                              ->assertSee('3');
                    });
        });
    }
    public function testCurrentPositionsModify()
    {
        $this->browse(function ($browser) {
            $browser->press('currentPositionsModify')
                    ->waitForText('Modify Position')
                    ->type('position', 'dusk')
                    ->type('positionEmail', 'no@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully modified.')
                    ->with('@currentPositionsTable', function ($table) {
                        $table->assertSee('dusk')
                              ->assertSee('Yes')
                              ->assertSee('no@dusk.com');
                    });
        });
    }
    public function testCurrentPositionsRemove()
    {
        $this->browse(function ($browser) {
            $browser->press('currentPositionsRemove')
                    ->waitForText('Delete Position Confirmation')
                    ->press('positionDelete')
                    ->waitForText('was successfully deleted.')
                    ->assertSee('Admin Panel');
        });
    }
    public function testAddPositionsError()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'no@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', '')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'no@dusk.com')
                    ->type('description', '')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->type('position', '')
                    ->type('positionEmail', 'test')
                    ->type('description', '')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->assertSee('Modify Position')
                    ->press('modifyPositionClose')
                    ->assertSee('Admin Panel')
                    ->pause(500);
        });
    }
    public function testAddPositions()
    {
        $this->browse(function ($browser) {
            $browser->press('addPosition')
                    ->waitForText('Modify Position')
                    ->type('position', 'Laravel Dusk')
                    ->type('positionEmail', 'dusk@dusk.com')
                    ->type('description', 'duskduskduskdusk')
                    ->check('#posLowNotify')
                    ->select('positionPrivilegeDropdown')
                    ->press('modifyPositionSubmit')
                    ->waitForText('was successfully added.')
                    ->with('@currentPositionsTable', function ($table) {
                        $table->assertSee('Laravel Dusk')
                              ->assertSee('Yes')
                              ->assertSee('dusk@dusk.com');
                    });
        
        });
    }
}
