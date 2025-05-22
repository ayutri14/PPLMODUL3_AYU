<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Note;

class MengeditNotes extends DuskTestCase
{
    /**
     * Test edit note after login.
     * @group notes
     */
    public function test_mengeditNotes(){
        $user = User::factory()->create([
            'email' => 'user' . uniqid() . '@mail.com',
            'password' => '123',
            'email_verified_at' => now(),
        ]);

        $note = Note::create([
            'penulis_id' => $user->id,
            'judul' => 'Judul Lama',
            'isi' => 'Isi lama',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
        $browser->visit('/login')
                        ->type('email', $user->email)
                        ->type('password', '123')
                        ->press('button[type=submit]')
                        ->assertPathIs('/dashboard')
                        ->visit('/edit-note-page/' . $note->id)
                        ->screenshot('edit-note-debug')
                        ->waitFor('input[name=title]', 5)
                        ->waitFor('textarea[name=description]', 5)
                        ->type('title', 'Judul Baru')
                        ->type('description', 'Isi baru hasil edit')
                        ->press('button[type=submit]')
                        ->pause(1500)
                        ->waitForLocation('/notes')
                        ->screenshot('after-edit-debug');
        });
    }
}