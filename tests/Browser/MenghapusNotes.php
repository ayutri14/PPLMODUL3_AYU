<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Note;
use Illuminate\Support\Facades\Hash;

class MenghapusNotes extends DuskTestCase
{
    /**
     * Test menghapus catatan setelah login.
     * @group notes
     */
    public function test_menghapusnotes()
    {
        // Buat user
        $user = User::factory()->create([
            'email' => 'user' . uniqid() . '@mail.com',
            'password' => Hash::make('123'),
            'email_verified_at' => now(),
        ]);

        // Buat note milik user
        $note = Note::create([
            'penulis_id' => $user->id,
            'judul' => 'Judul Hapus Dusk',
            'isi' => 'Isi catatan yang akan dihapus',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', '123')
                ->press('button[type=submit]')
                ->assertPathIs('/dashboard')
                ->visit('/notes')
                ->assertSee('Judul Hapus Dusk')
                ->screenshot('debug-notes-page') 
                ->waitFor("#delete-{$note->id}", 10)
                ->click("#delete-{$note->id}") 
                ->pause(1000)
                ->assertDontSee('Judul Hapus Dusk')
                ->screenshot('hapus-note-dusk');
        });

    }
}
