<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $baseCurrency = $product->currency;
            $otherCurrencies = Currency::where('id', '!=', $baseCurrency->id)->get();
            
            foreach ($otherCurrencies as $currency) {
                $convertedPrice = $product->price * ($currency->exchange_rate / $baseCurrency->exchange_rate);
                
                ProductPrice::create([
                    'product_id' => $product->id,
                    'currency_id' => $currency->id,
                    'price' => round($convertedPrice, 2)
                ]);
            }
        }
    }
}
