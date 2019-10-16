<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function handle()
{
    $xvfb = (new ProcessBuilder())
        ->setTimeout(null)
        ->setPrefix('/usr/bin/Xvfb')
        ->setArguments(['-ac',  ':0', '-screen', '0', '1280x1024x16'])
        ->getProcess();

    $xvfb->start();

    try {
        parent::handle();
    } finally {
        $xvfb->stop();
    }

    return;
}
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
