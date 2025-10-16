<!-- resources/views/livewire/admin/dashboard-reportes.blade.php -->
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="crud-title">Dashboard de Canjes</h1>
            <div class="crud-form-label">
            <p>Resumen general de canjes de promociones</p>
            </div>
        </div>
    </div>

    <!-- Total de Canjes -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary bg-opacity-10 rounded me-3">
                            <i class="bi bi-receipt text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total de Canjes</p>
                            <h3 class="mb-0 text-dark">{{ number_format($totalCanjes) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($readyToLoad)
    <!-- Gráficas -->
    <div class="row mb-4">
        <!-- Top 5 Tiendas - Gráfica de Barras -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Top 5 Tiendas con Más Canjes</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="tiendasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promociones Más Canjeadas - Gráfica de Dona -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Promociones Más Canjeadas</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="promocionesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas de Tiempo -->
    <div class="row mb-4">
        <!-- Canjes por Semana - Gráfica de Línea -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Canjes Esta Semana</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="semanaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canjes por Año - Gráfica de Barras -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Canjes por Mes ({{ date('Y') }})</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="anioChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Actualizar -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <button wire:click="cargarDatos" 
                        class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Actualizar Datos
                </button>
            </div>
        </div>
    </div>
    @else
    <!-- Loading State -->
    <div class="row">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted mt-2">Cargando datos del dashboard...</p>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Variable global para almacenar las instancias de gráficas
    let charts = {};

    function initCharts() {
        console.log('Inicializando gráficas...');
        
        // Destruir gráficas existentes si las hay
        Object.values(charts).forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        charts = {};

        // Datos para las gráficas
        const tiendasData = @json($tiendasTop);
        const promocionesData = @json($promocionesTop);
        const semanaData = @json($canjesPorSemana);
        const anioData = @json($canjesPorAnio);

        console.log('Total de canjes:', {{ $totalCanjes }});

        // Gráfica de Top Tiendas (Barras)
        const tiendasCanvas = document.getElementById('tiendasChart');
        if (tiendasCanvas) {
            const tiendasCtx = tiendasCanvas.getContext('2d');
            charts.tiendas = new Chart(tiendasCtx, {
                type: 'bar',
                data: {
                    labels: tiendasData.map(item => item.nombre),
                    datasets: [{
                        label: 'Total de Canjes',
                        data: tiendasData.map(item => item.total_canjes),
                        backgroundColor: 'rgba(13, 110, 253, 0.8)',
                        borderColor: 'rgb(13, 110, 253)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Gráfica de Promociones (Dona)
        const promocionesCanvas = document.getElementById('promocionesChart');
        if (promocionesCanvas) {
            const promocionesCtx = promocionesCanvas.getContext('2d');
            charts.promociones = new Chart(promocionesCtx, {
                type: 'doughnut',
                data: {
                    labels: promocionesData.map(item => item.nombre),
                    datasets: [{
                        data: promocionesData.map(item => item.total_canjes),
                        backgroundColor: [
                            'rgba(13, 110, 253, 0.8)',
                            'rgba(25, 135, 84, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(220, 53, 69, 0.8)',
                            'rgba(111, 66, 193, 0.8)'
                        ],
                        borderColor: [
                            'rgb(13, 110, 253)',
                            'rgb(25, 135, 84)',
                            'rgb(255, 193, 7)',
                            'rgb(220, 53, 69)',
                            'rgb(111, 66, 193)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Gráfica de Canjes por Semana (Línea)
        const semanaCanvas = document.getElementById('semanaChart');
        if (semanaCanvas) {
            const semanaCtx = semanaCanvas.getContext('2d');
            charts.semana = new Chart(semanaCtx, {
                type: 'line',
                data: {
                    labels: semanaData.map(item => item.dia),
                    datasets: [{
                        label: 'Canjes',
                        data: semanaData.map(item => item.total),
                        borderColor: 'rgb(13, 110, 253)',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(13, 110, 253)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Gráfica de Canjes por Año (Barras)
        const anioCanvas = document.getElementById('anioChart');
        if (anioCanvas) {
            const anioCtx = anioCanvas.getContext('2d');
            charts.anio = new Chart(anioCtx, {
                type: 'bar',
                data: {
                    labels: anioData.map(item => item.mes),
                    datasets: [{
                        label: 'Canjes',
                        data: anioData.map(item => item.total),
                        backgroundColor: 'rgba(25, 135, 84, 0.8)',
                        borderColor: 'rgb(25, 135, 84)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        console.log('Gráficas inicializadas correctamente');
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado');
        
        // Inicializar después de un breve delay
        setTimeout(() => {
            if (document.getElementById('tiendasChart')) {
                initCharts();
            }
        }, 500);
    });

    // Reinicializar gráficas cuando Livewire actualice los datos
    Livewire.hook('message.processed', (message, component) => {
        if (component.name === 'admin.dashboard-reportes') {
            setTimeout(initCharts, 100);
        }
    });
</script>
@endpush