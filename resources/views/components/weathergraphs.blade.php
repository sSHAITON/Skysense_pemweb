<div class="relative z-50 mx-auto px-4 mt-8 mb-20">
    <h2 class="text-2xl font-bold text-center mb-8">Historical Data</h2>

    <div class="flex justify-center mb-6">
        <input type="date" id="dateSelector"
            class="bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ date('Y-m-d') }}">
    </div>

    <!-- Updated error message div to match livedata styling -->
    <div id="chartError"
        class="hidden w-full md:w-[400px] p-4 rounded-lg bg-red-100 text-red-700 text-center mx-auto mb-4">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span class="alert-message"></span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="humidityChart"></canvas>
        </div>
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="temperatureChart"></canvas>
        </div>
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="pressureChart"></canvas>
        </div>
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="windChart"></canvas>
        </div>
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="rainChart"></canvas>
        </div>
        <div class="bg-blue-200 rounded-lg p-4 shadow-lg">
            <canvas id="uvChart"></canvas>
        </div>
    </div>
</div>

<script>
    let charts = {};

    function createChart(elementId, label, data, color) {
        const ctx = document.getElementById(elementId);
        charts[elementId] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: label,
                    data: [],
                    borderColor: color,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: color.replace('1)', '0.1)'),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#1e293b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            color: '#1e293b',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(30, 41, 59, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#1e293b',
                            font: {
                                weight: 'bold'
                            },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            color: 'rgba(30, 41, 59, 0.05)'
                        }
                    }
                }
            }
        });
        return charts[elementId];
    }

    function updateCharts() {
        const selectedDate = $('#dateSelector').val();
        $('#chartError').addClass('hidden').find('.alert-message').text('');

        $.ajax({
            url: '{{ route('weather.history') }}',
            method: 'GET',
            data: {
                date: selectedDate
            },
            success: function(data) {
                if (!data.labels || data.labels.length === 0) {
                    $('#chartError').removeClass('hidden').find('.alert-message')
                        .text('No data available for selected date');
                    return;
                }

                if (!charts.humidityChart) {
                    // Initialize charts if they don't exist
                    createChart('humidityChart', 'Humidity %', [], 'rgba(54, 162, 235, 1)');
                    createChart('temperatureChart', 'Temperature °C', [], 'rgba(255, 99, 132, 1)');
                    createChart('pressureChart', 'Pressure hPa', [], 'rgba(75, 192, 192, 1)');
                    createChart('windChart', 'Wind Speed km/h', [], 'rgba(255, 159, 64, 1)');
                    createChart('rainChart', 'Rain Intensity mm', [], 'rgba(153, 102, 255, 1)');
                    createChart('uvChart', 'UV Index', [], 'rgba(255, 206, 86, 1)');
                }

                // Clear previous data
                Object.keys(charts).forEach(chartId => {
                    const chart = charts[chartId];
                    chart.data.labels = [];
                    chart.data.datasets[0].data = [];
                });

                // Update all charts with new data
                Object.keys(charts).forEach(chartId => {
                    const chart = charts[chartId];
                    chart.data.labels = data.labels;

                    switch (chartId) {
                        case 'humidityChart':
                            chart.data.datasets[0].data = data.humidity;
                            break;
                        case 'temperatureChart':
                            chart.data.datasets[0].data = data.temperature;
                            break;
                        case 'pressureChart':
                            chart.data.datasets[0].data = data.pressure;
                            break;
                        case 'windChart':
                            chart.data.datasets[0].data = data.wind_speed;
                            break;
                        case 'rainChart':
                            chart.data.datasets[0].data = data.rainfall;
                            break;
                        case 'uvChart':
                            chart.data.datasets[0].data = data.uv_index;
                            break;
                    }
                    chart.update('none'); // Use 'none' for better performance
                });
            },
            error: function(xhr, status, error) {
                $('#chartError').removeClass('hidden').find('.alert-message')
                    .text(xhr.responseJSON?.error || 'Error loading data');
            }
        });
    }

    $(document).ready(function() {
        updateCharts();
        $('#dateSelector').change(function() {
            updateCharts();
        });
        setInterval(updateCharts, 60000); // Update every minute
    });
</script>
