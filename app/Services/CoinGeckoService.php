<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinGeckoService
{
    protected $baseUrl = 'https://api.coingecko.com/api/v3/';

    public function getTopCoins($perPage = 10)
    {
        $response = Http::get($this->baseUrl.'coins/markets', [
            'vs_currency' => 'eur',
            'order' => 'market_cap_desc',
            'per_page' => $perPage,
            'page' => 1,
        ]);

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }
}
