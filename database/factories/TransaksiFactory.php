<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaksi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_resi' => 'INV-210114001',
            'tanggal' => now(),
            'jenis_transaksi' => 'penjualan',
            'kasir_id' => 'U-210114001',
            'member_id' => 'M-210114001',
            'total' => 22000
        ];
    }
}
