<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Note;

class MenampilkanNotes extends DuskTestCase
{
    /**
     * Test show note after login.
     * @group notes
     */
    public function test_menampilannotes()
    {
        $user = User::factory()->create([
            'email' => 'user' . uniqid() . '@mail.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now(),
        ]);

        $note = Note::create([
            'penulis_id' => $user->id,
            'judul' => 'Judul Dusk',
            'isi' => 'Isi catatan Dusk',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
        $browser->visit('/login')
            ->type('email', $user->email)
            ->type('password', '123')
            ->press('button[type=submit]')
            ->assertPathIs('/dashboard')
            ->visit('/notes') 
            ->assertSee('Judul Dusk')
            ->assertSee('Isi catatan Dusk')
            ->screenshot('lihat-notes-dusk');
      });
    }
}