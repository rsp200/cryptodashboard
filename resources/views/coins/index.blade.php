<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/coins.css') }}">
</head>
<body class="page-overview">
    <h1>Crypto Dashboard</h1>

    <div class="status-bar {{ $fromCache ? 'cache-hit' : 'cache-miss' }}">
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
        <a href="/coins/refresh" class="refresh-btn">
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
                        <a href="/coins/{{ $coin->coin_id }}" class="coin-link">
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
