<?php

use App\Models\User;
use App\Models\AlatLab;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

beforeEach(function () {
    User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'), 
    ]);
});

test('user can login with correct credentials', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('@email-input', 'admin@example.com')
            ->type('@password-input', 'password')
            ->press('@login-button')
            ->assertPathIs('/dashboard');
    });
});


test('user can create new alat lab', function () {
    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab')
            ->click('@create-alatlab-button')
            ->assertPathIs('/alat-lab/create')
            ->type('@kode-input', 'ALAT-001')
            ->type('@nama-input', 'Mikroskop')
            ->type('@lokasi-input', 'Ruang A1')
            ->type('@jumlah-input', '5')
            ->select('@kondisi-select', 'Baik')
            ->press('@submit-create')
            ->assertPathIs('/alat-lab')
            ->assertSee('Data alat laboratorium berhasil ditambahkan.')
            ->assertSee('Mikroskop');
    });
});

test('cannot create alat lab with duplicate code', function () {
    AlatLab::factory()->create([
        'kode_alat' => 'DUPLICATE-CODE',
        'nama_alat' => 'Alat Duplikat A',
    ]);

    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab/create')
            ->type('@kode-input', 'DUPLICATE-CODE') 
            ->type('@nama-input', 'Alat Duplikat B')
            ->type('@jumlah-input', '1')
            ->select('@kondisi-select', 'Baik')
            ->press('@submit-create')
            
            ->assertPathIs('/alat-lab/create')
            ->assertSee('The kode alat has already been taken.')
            ->assertInputValue('@nama-input', 'Alat Duplikat B');
    });
});

test('cannot create alat lab with invalid quantity (less than 0)', function () {
    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab/create')
            ->type('@kode-input', 'ALAT-INVALID')
            ->type('@nama-input', 'Alat Uji Jumlah')
            ->type('@jumlah-input', '-5') 
            ->select('@kondisi-select', 'Baik')
            ->press('@submit-create')
            
            ->assertPathIs('/alat-lab/create')
            ->assertSee('The jumlah field must be at least 0.')
            ->assertInputValue('@kode-input', 'ALAT-INVALID');
    });
});

test('cannot create alat lab without required fields', function () {
    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab/create')
            ->type('@lokasi-input', 'A-Wing-Test') 
            ->press('@submit-create')
            
            ->assertPathIs('/alat-lab/create')
            ->assertSee('The kode alat field is required.')
            ->assertSee('The nama alat field is required.')
            ->assertSee('The jumlah field is required.')
            ->assertSee('The kondisi field is required.')
            ->assertInputValue('@lokasi-input', 'A-Wing-Test');
    });
});

test('created alat lab is displayed in index page', function () {
    AlatLab::factory()->create([
        'kode_alat' => 'ALAT-READ',
        'nama_alat' => 'Spektrofotometer',
        'kondisi' => 'Rusak Berat',
    ]);

    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab')
            ->assertSee('Spektrofotometer')
            ->assertSee('Rusak Berat');
    });
});

test('user can update existing alat lab', function () {
    $alat = AlatLab::factory()->create([
        'kode_alat' => 'ALAT-100',
        'nama_alat' => 'Oskiloskop',
        'kondisi' => 'Baik',
    ]);

    $this->browse(function (Browser $browser) use ($alat) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab')
            ->click('@edit-alatlab-' . $alat->id)
            ->assertPathIs('/alat-lab/' . $alat->id . '/edit')
            
            // Perbarui data
            ->clear('@nama-input')
            ->type('@nama-input', 'Oskiloskop Digital')
            ->select('@kondisi-select', 'Rusak Ringan')
            ->press('@submit-update')
            
            // Assert sukses
            ->assertPathIs('/alat-lab')
            ->assertSee('Data alat laboratorium berhasil diperbarui.')
            ->assertSee('Oskiloskop Digital')
            ->assertSee('Rusak Ringan');
    });
});

test('user can delete alat lab', function () {
    $alat = AlatLab::factory()->create([
        'kode_alat' => 'ALAT-200',
        'nama_alat' => 'Multimeter',
    ]);

    $this->browse(function (Browser $browser) use ($alat) {
        $browser->loginAs(User::first())
            ->visit('/alat-lab')
            ->assertSee('Multimeter')
            ->press('@delete-alatlab-' . $alat->id) 
            ->assertPathIs('/alat-lab')
            ->assertSee('Data alat laboratorium berhasil dihapus.')
            ->assertDontSee('Multimeter');
    });
});