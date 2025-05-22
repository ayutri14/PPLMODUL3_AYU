<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class CreateNotes extends DuskTestCase
{
    /**
     * Test create note after login.
     * @group notes
     */
    public function test_membuatNotes()
    {
        $user = User::factory()->create([
            'email' => 'user' . uniqid() . '@mail.com',
            'password' => ('123'),
            'email_verified_at' => now(),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->waitFor('input[name=email]', 5)
                ->type('email', $user->email)
                ->type('password', '123')
                ->press('button[type=submit]')
                ->assertPathIs('/dashboard')
                ->visit('/create-note')
                ->screenshot('after-visit-create')
                ->waitFor('input[name=isi]', 5)
                ->waitFor('textarea[name=description]', 5)
                ->type('description', 'Isi baru hasil edit Dusk')
                ->press('.btn-submit-note')
                ->screenshot('create-note-debug');
        });
    }
}