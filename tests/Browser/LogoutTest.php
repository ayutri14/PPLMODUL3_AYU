<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LogoutTest extends DuskTestCase
{
    /**
     * Test user can logout after login.
     * @group logout
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'email' => 'admin' . uniqid() . '@mail.com',
            'password' => bcrypt('123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '123')
                ->press('button[type=submit]')
                ->assertPathIs('/dashboard')
                ->screenshot('after-login')
                ->click('button.inline-flex.items-center')
                ->pause(500)
                ->screenshot('after-dropdown')
                ->clickLink('Log Out')
                ->assertPathIs('/');
        });
    }
}