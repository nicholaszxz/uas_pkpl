<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UserLevel::factory(1)->create();
        \App\Models\UserLevel::create([
            'name' => 'accounting'
        ]);
        \App\Models\UserLevel::create([
            'name' => 'admin-piutang'
        ]);
        \App\Models\UserLevel::create([
            'name' => 'admin-pembelian'
        ]);
        \App\Models\UserLevel::create([
            'name' => 'kasir'
        ]);

        \App\Models\User::factory(1)->create();
                        
        \App\Models\Member::factory(1)->create();
        \App\Models\Member::create([
            'kode_member' => 'U-00-02',
            'jenis_member' => 'supplier',
            'nama' => 'general-supplier',
            'unit' => 0
        ]);
        // \App\Models\Barang::factory(1)->create();
        // \App\Models\SatuanBarang::factory(1)->create();
        // \App\Models\Transaksi::factory(1)->create();
        // \App\Models\DetailTransaksi::factory(1)->create();
    }
}
