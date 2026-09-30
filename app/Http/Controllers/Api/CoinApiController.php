<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoinResource;
use App\Models\Coin;
use Illuminate\Http\Request;

/**
 * Crypto Dashboard API
 *
 * Base URL: /api
 *
 * Endpoints:
 *   GET    /coins          - Lijst van alle coins (gesorteerd op rank)
 *   GET    /coins/{id}     - Details van één coin (bijv. /coins/bitcoin)
 *   POST   /coins          - Nieuwe coin toevoegen (JSON body vereist)
 *   DELETE /coins/{id}     - Coin verwijderen
 *
 * Alle responses zijn JSON.
 * Voeg de header "Accept: application/json" toe aan elk request.
 */
class CoinApiController extends Controller
{
    public function index()
    {
        $coins = Coin::orderBy('market_cap_rank')->get();

        return CoinResource::collection($coins);
    }

    public function show($coin)
    {
        $record = Coin::where('coin_id', $coin)->first();

        if (! $record) {
            return response()->json(['message' => 'Coin not found'], 404);
        }

        return new CoinResource($record);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coin_id' => 'required|string|unique:coins,coin_id',
            'symbol' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'current_price' => 'required|numeric|min:0',
            'market_cap' => 'nullable|integer|min:0',
            'market_cap_rank' => 'nullable|integer|min:1',
            'price_change_percentage_24h' => 'nullable|numeric',
        ]);

        $validated['fetched_at'] = now();

        $coin = Coin::create($validated);

        return response()->json(new CoinResource($coin), 201);
    }

    public function destroy($coin)
    {
        $record = Coin::where('coin_id', $coin)->first();

        if (! $record) {
            return response()->json(
                [
                    'error' => 'Coin niet gevonden',
                ],
                404,
            );
        }

        $record->delete();

        return response()->json(null, 204);
    }
}
