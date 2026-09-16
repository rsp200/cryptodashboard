<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        h1 {
            color: #f5c542;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        th {
            background-color: #16213e;
            color: #f5c542;
        }
        tr:hover {
            background-color: #16213e;
        }
        .coin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .coin-info img {
            width: 28px;
            height: 28px;
        }
        .coin-symbol {
            color: #888;
            font-size: 0.85em;
        }
        .positive {
            color: #00c853;
        }
        .negative {
            color: #ff1744;
        }
    </style>
</head>
<body>
    <h1>Crypto Dashboard</h1>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 10px; border-radius: 5px;
        background-color: {{ $fromCache ? '#1b5e20' : '#e65100' }};">
        <div>
            @if ($fromCache)
                <span>&#x1f4be; Data uit cache (database)</span>
            @else
                <span>&#x1f310; Verse data opgehaald van CoinGecko API</span>
            @endif

            @if ($coins->isNotEmpty())
                <br>
                <small>Laatst opgehaald: {{ $coins->first()->fetched_at->format('d-m-Y H:i:s') }}</small>
            @endif
        </div>
        <a href="/coins/refresh" style="background-color: #f5c542; color: #1a1a2e; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: bold;">
            Ververs data
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Coin</th>
                <th>Prijs</th>
                <th>24u %</th>
                <th>Marktkapitalisatie</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coins as $coin)
                <tr>
                    <td>{{ $coin->market_cap_rank }}</td>
                    <td>
                        <a href="/coins/{{ $coin->coin_id }}" style="text-decoration: none; color: inherit;">
                            <div class="coin-info">
                                <img src="{{ $coin->image }}" alt="{{ $coin->name }}">
                                <span>{{ $coin->name }}</span>
                                <span class="coin-symbol">{{ strtoupper($coin->symbol) }}</span>
                            </div>
                        </a>
                    </td>
                    <td>&euro;{{ number_format($coin->current_price, 2, ',', '.') }}</td>
                    <td class="{{ $coin->price_change_percentage_24h >= 0 ? 'positive' : 'negative' }}">
                        {{ number_format($coin->price_change_percentage_24h, 2, ',', '.') }}%
                    </td>
                    <td>&euro;{{ number_format($coin->market_cap, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
