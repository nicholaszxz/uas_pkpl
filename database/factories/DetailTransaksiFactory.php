<?php

namespace Database\Factories;

use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailTransaksiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailTransaksi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transaksi_id' => 'INV-210114001',
            'kode_barang' => 'B-210114001',
            'nama_barang' => 'Gula Pasir',
            'jumlah' => 1,
            'satuan' => 'kg',
            'harga' => 22000
        ];
    }
}
