<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test Registrasi.
     * @group regis
     */
    public function testRegistration(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/') 
                ->pause(2000)
                ->assertSee('Enterprise Application Development')
                ->screenshot('home-debug')
                ->clickLink('Register') 
                ->assertPathIs('/register') 
                ->type('name', 'ayu') 
                ->type('email', 'ayu@mail.com') 
                ->type('password', '123') 
                ->type('password_confirmation', '123') 
                ->press('REGISTER') 
                ->pause(2000) 
                ->assertPathIs('/dashboard'); 
        });
    }
}