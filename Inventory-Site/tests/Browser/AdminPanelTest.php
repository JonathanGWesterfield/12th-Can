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
                    ->with('@tabletest', function ($table) {
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
    
}
