<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика посещений</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .chart-row { display: flex; flex-wrap: wrap; gap: 40px; margin-top: 30px; }
        .chart-box { flex: 1; min-width: 300px; }
        canvas { max-height: 400px; width: 100%; }
        .logout { margin-bottom: 20px; }
        .logout a { text-decoration: none; background: #dc3545; color: white; padding: 8px 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout">
            <a href="/logout">Выйти</a>
        </div>
        <h1>Статистика посещений</h1>
        <div class="chart-row">
            <div class="chart-box">
                <h3>Посещения по часам (уникальные IP)</h3>
                <canvas id="hourlyChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Разбивка по городам</h3>
                <canvas id="cityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        async function loadData() {
            try {
                const response = await fetch('/statistics/data');
                const data = await response.json();

                // График посещений по часам
                const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
                new Chart(hourlyCtx, {
                    type: 'line',
                    data: {
                        labels: data.hourly.map(item => item.hour),
                        datasets: [{
                            label: 'Уникальные посетители',
                            data: data.hourly.map(item => item.count),
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Количество' } },
                            x: { title: { display: true, text: 'Час' } }
                        }
                    }
                });

                // Круговая диаграмма по городам
                const cityCtx = document.getElementById('cityChart').getContext('2d');
                new Chart(cityCtx, {
                    type: 'pie',
                    data: {
                        labels: data.cities.map(item => item.city),
                        datasets: [{
                            data: data.cities.map(item => item.total),
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'right' },
                            tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} посещений` } }
                        }
                    }
                });
            } catch (err) {
                console.error('Ошибка загрузки данных:', err);
            }
        }

        loadData();
    </script>
</body>
</html>