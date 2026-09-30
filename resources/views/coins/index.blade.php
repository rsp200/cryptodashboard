<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <nav style="margin-bottom: 20px;">
        <a href="/coins" style="color: #f5c542; margin-right: 15px;">Dashboard</a>
        <a href="/contact" style="color: #e0e0e0;">Contact</a>
    </nav>

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

    <h2 style="color: #f5c542; margin-top: 40px;">Prijzen Top 10</h2>
    <div style="background-color: #16213e; border-radius: 10px; padding: 20px; margin-top: 10px;">
        <canvas id="priceChart"></canvas>
    </div>

    <h2 style="color: #f5c542; margin-top: 40px;">Marktverdeling</h2>
    <div style="background-color: #16213e; border-radius: 10px; padding: 20px; margin-top: 10px; max-width: 500px; margin-left: auto; margin-right: auto;">
        <canvas id="marketCapChart"></canvas>
    </div>

    <h2 style="color: #f5c542; margin-top: 40px;">Prijsverandering (24 uur)</h2>
    <div style="background-color: #16213e; border-radius: 10px; padding: 20px; margin-top: 10px;">
        <canvas id="changeChart"></canvas>
    </div>

    <script>
        const chartData = @json($chartData);

        // Kleuren array
        const colors = [
            '#f5c542', '#e74c3c', '#3498db', '#2ecc71', '#9b59b6',
            '#e67e22', '#1abc9c', '#34495e', '#e91e63', '#00bcd4'
        ];

        // === Prijzen Chart ===
        new Chart(document.getElementById('priceChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Prijs in EUR',
                    data: chartData.prices,
                    backgroundColor: colors,
                    borderWidth: 0,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#e0e0e0',
                            callback: function(value) {
                                return '€' + value.toLocaleString('nl-NL');
                            }
                        },
                        grid: { color: '#333' }
                    },
                    x: {
                        ticks: { color: '#e0e0e0' },
                        grid: { display: false }
                    }
                }
            }
        });

        // === Marktverdeling Chart ===
        new Chart(document.getElementById('marketCapChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.marketCaps,
                    backgroundColor: colors,
                    borderColor: '#1a1a2e',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#e0e0e0', padding: 15, usePointStyle: true }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                }
            }
        });

        // === Prijsverandering Chart ===
        const changeColors = chartData.changes.map(v => (v ?? 0) >= 0 ? '#00c853' : '#ff1744');

        new Chart(document.getElementById('changeChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Verandering in %',
                    data: chartData.changes,
                    backgroundColor: changeColors,
                    borderWidth: 0,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        ticks: {
                            color: '#e0e0e0',
                            callback: function(value) { return value + '%'; }
                        },
                        grid: { color: '#333' }
                    },
                    x: {
                        ticks: { color: '#e0e0e0' },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>
