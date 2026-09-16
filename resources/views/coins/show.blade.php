<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $coin->name }} - Crypto Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/coins.css') }}">
</head>
<body class="page-detail">
    <a href="/coins">&larr; Terug naar overzicht</a>

    <div class="coin-card">
        <div class="coin-header">
            <img src="{{ $coin->image }}" alt="{{ $coin->name }}">
            <div>
                <h1>{{ $coin->name }}</h1>
                <span class="coin-meta">{{ strtoupper($coin->symbol) }} · Rank #{{ $coin->market_cap_rank }}</span>
            </div>
        </div>

        <div class="stat">
            <span class="stat-label">Prijs:</span>
            <strong>&euro;{{ number_format($coin->current_price, 2, ',', '.') }}</strong>
        </div>

        <div class="stat">
            <span class="stat-label">24u verandering:</span>
            <strong class="{{ $coin->price_change_percentage_24h >= 0 ? 'positive' : 'negative' }}">
                {{ number_format($coin->price_change_percentage_24h, 2, ',', '.') }}%
            </strong>
        </div>

        <div class="stat">
            <span class="stat-label">Marktkapitalisatie:</span>
            <strong>&euro;{{ number_format($coin->market_cap, 0, ',', '.') }}</strong>
        </div>

        <div class="stat">
            <span class="stat-label">Laatst bijgewerkt:</span>
            {{ $coin->fetched_at->format('d-m-Y H:i:s') }}
        </div>
    </div>
</body>
</html>
