<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\to_excel>
 */
class ToExcelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourceData = json_decode(file_get_contents(public_path('
         Dewa/json/excel.json')), true);
        $randomItem = $this->faker->randomElement($sourceData);

        return [
            'code_barang' => $randomItem['kode_barang'],
            'nama' => $randomItem['nama_barang'],
            'qty' => fake()->numberBetween(1, 10),
            'pembeli' => 'offline',
            'harga_beli' => $randomItem['harga_beli'],
            'harga_jual' => $randomItem['harga_jual'],
            'tanggal' => \Carbon\Carbon::parse(
                fake()->dateTimeBetween('2025-07-07 07:00:00', '2025-07-07 23:00:00')
            )->setTimezone('Asia/Jakarta')->toDateTimeString(),
        ];
    }
}
