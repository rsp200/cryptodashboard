<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rank' => $this->market_cap_rank,
            'id' => $this->coin_id,
            'name' => $this->name,
            'symbol' => strtoupper($this->symbol),
            'price_eur' => $this->current_price,
            'change_24h' => $this->price_change_percentage_24h,
            'market_cap' => $this->market_cap,
            'image' => $this->image,
        ];
    }
}
