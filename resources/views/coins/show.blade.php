<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $coin->name }} - Crypto Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        h1 { color: #f5c542; }
        .coin-card {
            background-color: #16213e;
            border-radius: 10px;
            padding: 30px;
            margin-top: 20px;
        }
        .coin-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .coin-header img { width: 48px; height: 48px; }
        .stat { margin: 10px 0; }
        .stat-label { color: #888; }
        .positive { color: #00c853; }
        .negative { color: #ff1744; }
        a { color: #f5c542; }
    </style>
</head>
<body>
    <a href="/coins">&larr; Terug naar overzicht</a>

    <div class="coin-card">
        <div class="coin-header">
            <img src="{{ $coin->image }}" alt="{{ $coin->name }}">
            <div>
                <h1 style="margin: 0;">{{ $coin->name }}</h1>
                <span style="color: #888;">{{ strtoupper($coin->symbol) }} · Rank #{{ $coin->market_cap_rank }}</span>
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
