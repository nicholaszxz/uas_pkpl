<?php

namespace Database\Factories;

use App\Models\SatuanBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

class SatuanBarangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SatuanBarang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode_barang' => 'B-210114001',
            'nama_satuan' => 'unit',
            'rasio' => 1,
            'harga_beli' => 15000,
            'harga_jual' => 55000
        ];
    }
}
