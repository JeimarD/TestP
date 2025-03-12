<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'US Dollar',
                'symbol' => 'USD',
                'exchange_rate' => 1.0000
            ],
            [
                'name' => 'Euro',
                'symbol' => 'EUR',
                'exchange_rate' => 0.8500
            ],
            [
                'name' => 'Colombian Peso',
                'symbol' => 'COP',
                'exchange_rate' => 4000.0000
            ]
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
