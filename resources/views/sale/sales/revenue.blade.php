@extends('sale.layouts.master')

@section('title', __('Revenue Statistics'))

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        margin-bottom: 20px;
    }
    
    .stats-card {
        border-radius: 10px;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card .card-body {
        padding: 1.5rem;
    }
    
    .stats-value {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 0;
    }
    
    .stats-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .stats-icon {
        font-size: 2rem;
        opacity: 0.7;
    }
    
    .percentage-indicator {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 50px;
        font-size: 12px;
        margin-left: 5px;
    }
    
    .percentage-up {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .percentage-down {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .table-stats {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .period-selector button {
        border-radius: 50px;
        padding: 0.25rem 1rem;
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        font-weight: 500;
    }
    
    .loader-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .spinner {
        width: 3rem;
        height: 3rem;
    }
    
    #summary-section {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1>{{ __('Revenue Statistics') }}</h1>
        <div>
            <button class="btn btn-sm btn-success shadow-sm mr-2" id="exportExcel">
                <i class="fas fa-download fa-sm text-white-50"></i> {{ __('Export Excel') }}
            </button>
            <button class="btn btn-sm btn-danger shadow-sm" id="exportPDF">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> {{ __('Export PDF') }}
            </button>
        </div>
    </div>

    <!-- Date Range Picker -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-calendar-alt mr-1"></i> {{ __('Filter by Date Range') }}
            </h6>
            <div class="period-selector">
                <button class="btn btn-outline-primary btn-sm period-btn" data-days="7">{{ __('Last 7 days') }}</button>
                <button class="btn btn-outline-primary btn-sm period-btn" data-days="30">{{ __('Last 30 days') }}</button>
                <button class="btn btn-outline-primary btn-sm period-btn" data-days="90">{{ __('Last 90 days') }}</button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('sale.sales.revenue') }}" class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" class="form-control" id="daterange" name="daterange" 
                            value="{{ \Carbon\Carbon::parse($startDate)->format('m/d/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('m/d/Y') }}">
                        <input type="hidden" id="start_date" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" id="end_date" name="end_date" value="{{ $endDate }}">
                    </div>
                </div>
                <div class="col-md-7">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> {{ __('Apply Filter') }}
                    </button>
                    <a href="{{ route('sale.sales.revenue') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-sync-alt"></i> {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards Section -->
    <div id="summary-section" class="row">
        <!-- Today's Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __("Today's Revenue") }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['todayRevenue'], 0, ',', '.') }} đ</div>
                            @if(isset($comparisonWithPreviousPeriod))
                            <div class="mt-2 text-xs">
                                @if($comparisonWithPreviousPeriod['percentageChange'] > 0)
                                    <span class="percentage-indicator percentage-up">
                                        <i class="fas fa-arrow-up mr-1"></i>{{ number_format($comparisonWithPreviousPeriod['percentageChange'], 2) }}%
                                    </span>
                                @elseif($comparisonWithPreviousPeriod['percentageChange'] < 0)
                                    <span class="percentage-indicator percentage-down">
                                        <i class="fas fa-arrow-down mr-1"></i>{{ number_format(abs($comparisonWithPreviousPeriod['percentageChange']), 2) }}%
                                    </span>
                                @else
                                    <span class="percentage-indicator">
                                        <i class="fas fa-equals mr-1"></i>0%
                                    </span>
                                @endif
                                <span class="text-muted">{{ __('vs previous period') }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Week's Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __("This Week's Revenue") }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['thisWeekRevenue'], 0, ',', '.') }} đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Month's Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __("This Month's Revenue") }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['thisMonthRevenue'], 0, ',', '.') }} đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Year's Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __("This Year's Revenue") }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['thisYearRevenue'], 0, ',', '.') }} đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Revenue Breakdown') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="revenueBreakdownLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="revenueBreakdownChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-xs font-weight-bold text-primary mb-1">{{ __('Sales Revenue') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['totalSalesRevenue'], 0, ',', '.') }} đ</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-xs font-weight-bold text-info mb-1">{{ __('Rental Revenue') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($summaryStats['totalRentalRevenue'], 0, ',', '.') }} đ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Top Selling Products') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-stats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Units Sold') }}</th>
                                    <th>{{ __('Revenue') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topSellingProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->total_quantity) }}</td>
                                    <td>{{ number_format($product->total_revenue, 0, ',', '.') }} đ</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">{{ __('No data available') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Daily Revenue Chart -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Daily Revenue') }}</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">{{ __('Export Options') }}:</div>
                            <a class="dropdown-item" href="#" id="exportDailyChartPNG">{{ __('Export as PNG') }}</a>
                            <a class="dropdown-item" href="#" id="exportDailyChartJPG">{{ __('Export as JPG') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" id="exportDailyData">{{ __('Export Data as CSV') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="dailyRevenueLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="dailyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Weekly Revenue Chart -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Weekly Revenue') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="weeklyRevenueLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="weeklyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Category Chart -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Revenue by Category') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="categoryRevenueLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="categoryRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Revenue Chart -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Monthly Revenue') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="monthlyRevenueLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yearly Revenue Chart -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Yearly Revenue') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div id="yearlyRevenueLoader" class="loader-overlay">
                            <div class="spinner-border text-primary spinner" role="status">
                                <span class="sr-only">{{ __('Processing') }}...</span>
                            </div>
                        </div>
                        <canvas id="yearlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment/dist/chartjs-adapter-moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set daterangepicker locale to match app locale
    const currentLocale = '{{ app()->getLocale() }}';
    if (currentLocale === 'vi') {
        moment.locale('vi', {
            months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            monthsShort: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
            weekdays: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            weekdaysShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            weekdaysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
        });
    }
    
    // Initialize date range picker with localized labels
    $('#daterange').daterangepicker({
        startDate: moment('{{ $startDate }}'),
        endDate: moment('{{ $endDate }}'),
        locale: {
            format: 'DD/MM/YYYY',
            applyLabel: '{{ __("Apply Filter") }}',
            cancelLabel: '{{ __("Reset") }}',
            customRangeLabel: '{{ __("Custom Range") }}',
            daysOfWeek: currentLocale === 'vi' ? ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'] : ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: currentLocale === 'vi' ? 
                ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'] :
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        ranges: {
           '{{ __("Today") }}': [moment(), moment()],
           '{{ __("Yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '{{ __("Last 7 days") }}': [moment().subtract(6, 'days'), moment()],
           '{{ __("Last 30 days") }}': [moment().subtract(29, 'days'), moment()],
           '{{ __("This Month") }}': [moment().startOf('month'), moment().endOf('month')],
           '{{ __("Last Month") }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(start, end) {
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
    });

    // Handle period buttons
    $('.period-btn').on('click', function() {
        const days = $(this).data('days');
        const end = moment();
        const start = moment().subtract(days - 1, 'days');
        
        $('#daterange').data('daterangepicker').setStartDate(start);
        $('#daterange').data('daterangepicker').setEndDate(end);
        
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        
        $('form').submit();
    });

    // Global chart plugin to display "No data available" message
    Chart.register({
        id: 'noDataPlugin',
        beforeDraw: function(chart) {
            if (chart.data.datasets.length === 0 || 
                (chart.data.datasets[0].data.length === 0) ||
                (chart.data.datasets[0].data.every(value => value === 0 || value === null || value === undefined))) {
                
                // No data available
                let ctx = chart.ctx;
                let width = chart.width;
                let height = chart.height;
                
                chart.clear();
                
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.fillText('{{ __("No data available") }}', width / 2, height / 2);
                ctx.restore();
                
                return false; // stops the chart from drawing
            }
        }
    });

    // Color variables
    const colors = {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        secondary: '#858796',
    };

    // Number format based on locale
    function formatCurrency(value) {
        return new Intl.NumberFormat('{{ app()->getLocale() === "vi" ? "vi-VN" : "en-US" }}').format(value) + ' đ';
    }

    // Chart options
    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += formatCurrency(context.parsed.y || 0);
                        return label;
                    }
                }
            }
        }
    };

    // Revenue Breakdown Chart - immediate display
    const revenueBreakdownData = {
        labels: ['{{ __("Sales Revenue") }}', '{{ __("Rental Revenue") }}'],
        datasets: [{
            data: [
                {{ $summaryStats['totalSalesRevenue'] ?? 0 }},
                {{ $summaryStats['totalRentalRevenue'] ?? 0 }}
            ],
            backgroundColor: [colors.primary, colors.info],
            hoverBackgroundColor: [
                'rgba(78, 115, 223, 0.8)',
                'rgba(54, 185, 204, 0.8)'
            ],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
    };

    // Create Revenue Breakdown chart with no data handling
    const revenueBreakdownConfig = {
        type: 'doughnut',
        data: revenueBreakdownData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = formatCurrency(context.raw || 0);
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + (b || 0), 0);
                            console.log("Total revenue:", total); // Debugging: Log the total revenue
                            const percentage = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                            console.log("Category:", label, "Value:", context.raw, "Percentage:", percentage); // Debugging: Log category, value, and percentage
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    };

    // Create Revenue Breakdown chart immediately
    const revenueBreakdownCtx = document.getElementById('revenueBreakdownChart');
    if (revenueBreakdownCtx) {
        // Check if there's any data
        const hasBreakdownData = revenueBreakdownData.datasets[0].data.some(value => value > 0);
        
        new Chart(revenueBreakdownCtx, revenueBreakdownConfig);
        document.getElementById('revenueBreakdownLoader').style.display = 'none';
    }

    // Daily Revenue Chart - immediate display
    try {
        const dailyLabels = Object.keys(@json($dailyRevenue));
        const dailyData = Object.values(@json($dailyRevenue)).map(item => item.revenue);
        
        const dailyRevenueCtx = document.getElementById('dailyRevenueChart');
        if (dailyRevenueCtx) {
            new Chart(dailyRevenueCtx, {
                type: 'line',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: '{{ __("Daily Revenue") }}',
                        data: dailyData,
                        borderColor: colors.primary,
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: colors.primary,
                        pointBorderColor: '#fff',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: colors.primary,
                        pointHoverBorderColor: '#fff',
                        pointHitRadius: 10,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    ...defaultOptions,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                parser: 'YYYY-MM-DD',
                                tooltipFormat: currentLocale === 'vi' ? 'DD/MM/YYYY' : 'll',
                                displayFormats: {
                                    day: currentLocale === 'vi' ? 'DD/MM' : 'MMM D'
                                }
                            },
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('dailyRevenueLoader').style.display = 'none';
        }
    } catch (e) {
        console.error('Error initializing Daily Revenue Chart:', e);
        document.getElementById('dailyRevenueLoader').style.display = 'none';
    }

    // Weekly Revenue Chart - immediate display
    try {
        const weeklyLabels = @json(array_map(function($item) {
            return $item['start_date'] . ' - ' . $item['end_date'];
        }, $weeklyRevenue));
        
        const weeklyData = @json(array_map(function($item) {
            return (float) $item['revenue'];
        }, $weeklyRevenue));
        
        const weeklyRevenueCtx = document.getElementById('weeklyRevenueChart');
        if (weeklyRevenueCtx) {
            new Chart(weeklyRevenueCtx, {
                type: 'bar',
                data: {
                    labels: weeklyLabels,
                    datasets: [{
                        label: '{{ __("Weekly Revenue") }}',
                        data: weeklyData,
                        backgroundColor: 'rgba(28, 200, 138, 0.7)',
                        borderColor: colors.success,
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(28, 200, 138, 0.9)',
                        hoverBorderColor: colors.success,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    ...defaultOptions,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('weeklyRevenueLoader').style.display = 'none';
        }
    } catch (e) {
        console.error('Error initializing Weekly Revenue Chart:', e);
        document.getElementById('weeklyRevenueLoader').style.display = 'none';
    }

    // Category Revenue Chart - immediate display
    try {
        const categoryLabels = @json($revenueByCategory ? $revenueByCategory->pluck('name')->toArray() : []);
        const categoryData = @json($revenueByCategory ? $revenueByCategory->pluck('total_revenue')->toArray() : []);
        
        const categoryColors = [
            'rgba(78, 115, 223, 0.7)',
            'rgba(28, 200, 138, 0.7)',
            'rgba(54, 185, 204, 0.7)',
            'rgba(246, 194, 62, 0.7)',
            'rgba(231, 74, 59, 0.7)',
            'rgba(133, 135, 150, 0.7)'
        ];
        
        const categoryRevenueCtx = document.getElementById('categoryRevenueChart');
        if (categoryRevenueCtx) {
            new Chart(categoryRevenueCtx, {
                type: 'pie',
                data: {
                    labels: categoryLabels.length > 0 ? categoryLabels : ['{{ __("No data") }}'],
                    datasets: [{
                        data: categoryData.length > 0 ? categoryData : [0],
                        backgroundColor: categoryColors,
                        hoverBackgroundColor: categoryColors.map(color => color.replace('0.7', '0.9')),
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = formatCurrency(context.raw || 0);
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + (b || 0), 0);
                                    console.log("Total revenue:", total); // Debugging: Log the total revenue
                                    const percentage = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                                    console.log("Category:", label, "Value:", context.raw, "Percentage:", percentage); // Debugging: Log category, value, and percentage
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('categoryRevenueLoader').style.display = 'none';
        }
    } catch (e) {
        console.error('Error initializing Category Revenue Chart:', e);
        document.getElementById('categoryRevenueLoader').style.display = 'none';
    }

    // Monthly Revenue Chart - update to match weekly revenue chart format
    try {
        console.log('Processing monthly revenue data');
        const monthlyLabels = [];
        const monthlyTotalData = [];
        
        @if(isset($monthlyRevenue) && !empty($monthlyRevenue))
            console.log('Monthly revenue data exists:', @json($monthlyRevenue));
            
            // Process data to get total revenue per month
            @foreach($monthlyRevenue as $month => $revenues)
                monthlyLabels.push('{{ $month }}');
                
                // Calculate total revenue for this month (sum of rental and sale)
                let totalRevenue = 0;
                @foreach($revenues as $revenue)
                    totalRevenue += {{ $revenue["revenue"] }};
                @endforeach
                
                monthlyTotalData.push(totalRevenue);
            @endforeach
        @else
            console.log('No monthly revenue data available');
            // Default month if no data
            const currentMonth = moment().format('YYYY-MM');
            monthlyLabels.push(currentMonth);
            monthlyTotalData.push(0);
        @endif
        
        console.log('Monthly labels:', monthlyLabels);
        console.log('Monthly total data:', monthlyTotalData);
        
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
        if (monthlyRevenueCtx) {
            new Chart(monthlyRevenueCtx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels.map(month => {
                        return moment(month + '-01').format('MMM YYYY');
                    }),
                    datasets: [{
                        label: '{{ __("Monthly Revenue") }}',
                        data: monthlyTotalData,
                        backgroundColor: 'rgba(54, 185, 204, 0.7)',
                        borderColor: colors.info,
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(54, 185, 204, 0.9)',
                        hoverBorderColor: colors.info,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    ...defaultOptions,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('monthlyRevenueLoader').style.display = 'none';
        }
    } catch (e) {
        console.error('Error initializing Monthly Revenue Chart:', e);
        document.getElementById('monthlyRevenueLoader').style.display = 'none';
    }

    // Yearly Revenue Chart - update to match weekly revenue chart format
    try {
        console.log('Processing yearly revenue data');
        const yearlyLabels = [];
        const yearlyTotalData = [];
        
        @if(isset($yearlyRevenue) && !empty($yearlyRevenue))
            console.log('Yearly revenue data exists:', @json($yearlyRevenue));
            
            // Process data to get total revenue per year
            @foreach($yearlyRevenue as $year => $revenues)
                yearlyLabels.push('{{ $year }}');
                
                // Calculate total revenue for this year (sum of rental and sale)
                let totalRevenue = 0;
                @foreach($revenues as $revenue)
                    totalRevenue += {{ $revenue["revenue"] }};
                @endforeach
                
                yearlyTotalData.push(totalRevenue);
            @endforeach
        @else
            console.log('No yearly revenue data available');
            // Default year if no data
            const currentYear = moment().format('YYYY');
            yearlyLabels.push(currentYear);
            yearlyTotalData.push(0);
        @endif
        
        console.log('Yearly labels:', yearlyLabels);
        console.log('Yearly total data:', yearlyTotalData);
        
        const yearlyRevenueCtx = document.getElementById('yearlyRevenueChart');
        if (yearlyRevenueCtx) {
            new Chart(yearlyRevenueCtx, {
                type: 'bar',
                data: {
                    labels: yearlyLabels,
                    datasets: [{
                        label: '{{ __("Yearly Revenue") }}',
                        data: yearlyTotalData,
                        backgroundColor: 'rgba(28, 200, 138, 0.7)',
                        borderColor: colors.success,
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(28, 200, 138, 0.9)',
                        hoverBorderColor: colors.success,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    ...defaultOptions,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('yearlyRevenueLoader').style.display = 'none';
        }
    } catch (e) {
        console.error('Error initializing Yearly Revenue Chart:', e);
        document.getElementById('yearlyRevenueLoader').style.display = 'none';
    }

    // Export functionality
    $('#exportExcel').click(function() {
        window.location.href = "{{ route('sale.sales.export', ['type' => 'excel']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}";
    });
    
    $('#exportPDF').click(function() {
        window.location.href = "{{ route('sale.sales.export', ['type' => 'pdf']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}";
    });

    // Export chart as image
    $('#exportDailyChartPNG').click(function() {
        exportChart('dailyRevenueChart', 'png', 'daily-revenue');
    });
    
    $('#exportDailyChartJPG').click(function() {
        exportChart('dailyRevenueChart', 'jpg', 'daily-revenue');
    });

    function exportChart(chartId, format, filename) {
        const canvas = document.getElementById(chartId);
        if (!canvas) return;
        
        const imgData = canvas.toDataURL('image/' + format);
        
        const link = document.createElement('a');
        link.download = filename + '.' + format;
        link.href = imgData;
        link.click();
    }

    // Export chart data as CSV
    $('#exportDailyData').click(function() {
        exportDataAsCSV('dailyRevenueChart', 'daily-revenue-data');
    });

    function exportDataAsCSV(chartId, filename) {
        const chart = Chart.getChart(chartId);
        if (!chart) return;
        
        const labels = chart.data.labels;
        const datasets = chart.data.datasets;
        
        let csvContent = "data:text/csv;charset=utf-8,";
        
        // Create header row
        let headerRow = "Date";
        datasets.forEach(dataset => {
            headerRow += "," + dataset.label;
        });
        csvContent += headerRow + "\r\n";
        
        // Create data rows
        labels.forEach((label, i) => {
            let row = label;
            datasets.forEach(dataset => {
                row += "," + dataset.data[i];
            });
            csvContent += row + "\r\n";
        });
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
});
</script>
@endsection
