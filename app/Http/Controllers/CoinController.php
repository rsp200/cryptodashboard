<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Services\CoinGeckoService;
use Carbon\Carbon;

class CoinController extends Controller
{
    public function index()
    {
        $cacheMinutes = 10;

        // Stap 1: pak de meest recent opgehaalde coin uit de database
        $latestCoin = Coin::orderBy('fetched_at', 'desc')->first();

        // Stap 2: data is verlopen als er geen coin is, of de nieuwste ouder is dan 10 minuten
        $dataIsExpired = ! $latestCoin || $latestCoin->fetched_at < Carbon::now()->subMinutes($cacheMinutes);

        if ($dataIsExpired) {
            // Stap 3a: verse data ophalen van de API en opslaan
            $this->fetchAndStoreCoins();
            $fromCache = false;
        } else {
            // Stap 3b: data is nog vers, gebruik de database
            $fromCache = true;
        }

        $coins = Coin::orderBy('market_cap_rank')->get();

        return view('coins.index', compact('coins', 'fromCache'));
    }

    public function refresh()
    {
        $this->fetchAndStoreCoins();

        return redirect('/coins');
    }

    public function show($coin_id)
    {
        $coin = Coin::where('coin_id', $coin_id)->firstOrFail();

        return view('coins.show', compact('coin'));
    }

    /**
     * Haal de top coins op van de CoinGecko API en werk de database bij.
     */
    private function fetchAndStoreCoins(): void
    {
        $service = new CoinGeckoService;
        $apiCoins = $service->getTopCoins();

        foreach ($apiCoins as $apiCoin) {
            Coin::updateOrCreate(
                ['coin_id' => $apiCoin['id']],
                [
                    'symbol' => $apiCoin['symbol'],
                    'name' => $apiCoin['name'],
                    'image' => $apiCoin['image'],
                    'current_price' => $apiCoin['current_price'],
                    'market_cap' => $apiCoin['market_cap'],
                    'market_cap_rank' => $apiCoin['market_cap_rank'],
                    'price_change_percentage_24h' => $apiCoin['price_change_percentage_24h'],
                    'fetched_at' => now(),
                ]
            );
        }
    }
}
