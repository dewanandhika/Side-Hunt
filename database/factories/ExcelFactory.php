<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\excel>
 */
class ExcelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $sourceData = null;
        if ($sourceData === null) {
            $sourceData = json_decode(file_get_contents(public_path('Dewa/json/excel.json')), true);
        }

        $randomItem = fake()->randomElement($sourceData);
        $qty = fake()->numberBetween(1, 10);
        $harga_jual = $randomItem['harga_jual'];
        $harga_beli = $randomItem['harga_beli'];
        $total_jual = $qty * $harga_jual;
        $total_beli = $qty * $harga_beli;

        return [
            'code_barang' => $randomItem['kode_barang'],
            'nama' => $randomItem['nama_barang'],
            'qty' => $qty,
            'pembeli' => 'offline',
            'harga_beli' => $harga_beli,
            'total_jual' => $total_jual,
            'total_beli' => $total_beli,
            'harga_jual' => $harga_jual,
            'tanggal' => fake()->dateTimeBetween('2025-07-07 07:00:00', '2025-07-07 23:00:00'),
        ];
    }
}
