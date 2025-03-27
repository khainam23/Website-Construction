@extends('staff.layouts.master')

@section('title', __('Revenue Statistics'))

@section('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h1>{{ __('Revenue Statistics') }}</h1>

    <!-- Date range filter -->
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Filter by Date Range') }}
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('staff.sales.revenue') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">{{ __('Apply Filter') }}</button>
                    <a href="{{ route('staff.sales.revenue') }}" class="btn btn-secondary ms-2">{{ __('Reset') }}</a>
                    <button type="button" class="btn btn-success ml-3" onclick="exportExcel()">{{ __('Export File') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daily Revenue -->
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Daily Revenue') }}
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
            <!-- Table content... -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($dailyRevenue) && count($dailyRevenue) > 0)
                        @foreach($dailyRevenue as $date => $data)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ number_format($data['revenue'], 2) }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" class="text-center">{{ __('No data available') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Weekly Revenue -->
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Weekly Revenue') }}
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="weeklyRevenueChart"></canvas>
            </div>
            <!-- Table content... -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Week') }}</th>
                            <th>{{ __('Start Date') }}</th>
                            <th>{{ __('End Date') }}</th>
                            <th>{{ __('Revenue') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($weeklyRevenue) && count($weeklyRevenue) > 0)
                        @foreach($weeklyRevenue as $data)
                        <tr>
                            <td>{{ $data['week'] }}</td>
                            <td>{{ $data['start_date'] }}</td>
                            <td>{{ $data['end_date'] }}</td>
                            <td>{{ number_format($data['revenue'], 2) }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">{{ __('No data available') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Monthly Revenue') }}
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
            <!-- Table content... -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Month') }}</th>
                            <th>{{ __('Revenue') }}</th>
                            <th>{{ __('Type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyRevenue as $month => $revenues)
                        @foreach ($revenues as $revenue)
                        <tr>
                            <td>{{ $revenue['month'] }}</td>
                            <td>{{ number_format($revenue['revenue'], 2) }}</td>
                            <td>{{ __($revenue['type']) }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Annual Revenue -->
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Annual Revenue') }}
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="yearlyRevenueChart"></canvas>
            </div>
            <!-- Table content... -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Year') }}</th>
                            <th>{{ __('Revenue') }}</th>
                            <th>{{ __('Type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($yearlyRevenue as $year => $revenues)
                        @foreach ($revenues as $revenue)
                        <tr>
                            <td>{{ $revenue['year'] }}</td>
                            <td>{{ number_format($revenue['revenue'], 2) }}</td>
                            <td>{{ __($revenue['type']) }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Revenue scripts loaded');

        // Debug available canvas elements
        console.log('Daily Chart Canvas:', document.getElementById('dailyRevenueChart'));
        console.log('Weekly Chart Canvas:', document.getElementById('weeklyRevenueChart'));
        console.log('Monthly Chart Canvas:', document.getElementById('monthlyRevenueChart'));
        console.log('Yearly Chart Canvas:', document.getElementById('yearlyRevenueChart'));

        // Daily Revenue Chart
        @if(isset($dailyRevenue) && count($dailyRevenue) > 0)
        try {
            console.log('Initializing Daily Revenue Chart with data:', @json($dailyRevenue));
            const dailyLabels = Object.keys(@json($dailyRevenue));
            const dailyData = Object.values(@json($dailyRevenue)).map(item => item.revenue);

            const dailyCtx = document.getElementById('dailyRevenueChart');
            if (dailyCtx) {
                new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            label: '{{ __("Daily Revenue") }}',
                            data: dailyData,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.1,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            } else {
                console.error('Daily Revenue Chart canvas element not found');
            }
        } catch (e) {
            console.error('Error initializing Daily Revenue Chart:', e);
        }
        @else
        console.log('No daily revenue data available');
        @endif

        // Weekly Revenue Chart
        @if(isset($weeklyRevenue) && count($weeklyRevenue) > 0)
        try {
            console.log('Initializing Weekly Revenue Chart');
            const weeklyLabels = @json(array_map(function($item) {
                return $item['week'];
            }, $weeklyRevenue));
            const weeklyData = @json(array_map(function($item) {
                return (float) $item['revenue'];
            }, $weeklyRevenue));

            const weeklyCtx = document.getElementById('weeklyRevenueChart');
            if (weeklyCtx) {
                new Chart(weeklyCtx, {
                    type: 'bar',
                    data: {
                        labels: weeklyLabels,
                        datasets: [{
                            label: '{{ __("Weekly Revenue") }}',
                            data: weeklyData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgb(54, 162, 235)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Weekly Revenue Chart canvas element not found');
            }
        } catch (e) {
            console.error('Error initializing Weekly Revenue Chart:', e);
        }
        @endif

        // Monthly Revenue Chart
        @if(isset($monthlyRevenue) && count($monthlyRevenue) > 0)
        try {
            console.log('Initializing Monthly Revenue Chart');
            // Process monthly data for chart
            const monthlyData = {};
            let monthLabels = [];

            @foreach($monthlyRevenue as $month => $revenues)
            monthlyData['{{ $month }}'] = {
                rental: 0,
                staff: 0,
                total: 0
            };
            monthLabels.push('{{ $month }}');

            @foreach($revenues as $revenue)
            monthlyData['{{ $month }}']['{{ $revenue['
                type '] }}'
            ] += parseFloat({
                {
                    $revenue['revenue']
                }
            });
            monthlyData['{{ $month }}']['total'] += parseFloat({
                {
                    $revenue['revenue']
                }
            });
            @endforeach
            @endforeach

            const rentalData = monthLabels.map(month => monthlyData[month].rental);
            const saleData = monthLabels.map(month => monthlyData[month].staff);
            const totalMonthlyData = monthLabels.map(month => monthlyData[month].total);

            const monthlyCtx = document.getElementById('monthlyRevenueChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                                label: '{{ __("Rental Revenue") }}',
                                data: rentalData,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgb(255, 99, 132)',
                                borderWidth: 1
                            },
                            {
                                label: '{{ __("Sales Revenue") }}',
                                data: saleData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 1
                            },
                            {
                                label: '{{ __("Total Revenue") }}',
                                data: totalMonthlyData,
                                type: 'line',
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Monthly Revenue Chart canvas element not found');
            }
        } catch (e) {
            console.error('Error initializing Monthly Revenue Chart:', e);
        }
        @else
        console.log('No monthly revenue data available');
        document.getElementById('monthlyRevenueChart').remove();
        @endif

        // Yearly Revenue Chart
        @if(isset($yearlyRevenue) && count($yearlyRevenue) > 0)
        try {
            console.log('Initializing Yearly Revenue Chart');
            // Process yearly data for chart
            const yearlyData = {};
            let yearLabels = [];

            @foreach($yearlyRevenue as $year => $revenues)
            yearlyData['{{ $year }}'] = {
                rental: 0,
                staff: 0,
                total: 0
            };
            yearLabels.push('{{ $year }}');

            @foreach($revenues as $revenue)
            yearlyData['{{ $year }}']['{{ $revenue['
                type '] }}'
            ] += parseFloat({
                {
                    $revenue['revenue']
                }
            });
            yearlyData['{{ $year }}']['total'] += parseFloat({
                {
                    $revenue['revenue']
                }
            });
            @endforeach
            @endforeach

            const yearlyRentalData = yearLabels.map(year => yearlyData[year].rental);
            const yearlySaleData = yearLabels.map(year => yearlyData[year].staff);
            const totalYearlyData = yearLabels.map(year => yearlyData[year].total);

            const yearlyCtx = document.getElementById('yearlyRevenueChart');
            if (yearlyCtx) {
                new Chart(yearlyCtx, {
                    type: 'bar',
                    data: {
                        labels: yearLabels,
                        datasets: [{
                                label: '{{ __("Rental Revenue") }}',
                                data: yearlyRentalData,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgb(255, 99, 132)',
                                borderWidth: 1
                            },
                            {
                                label: '{{ __("Sales Revenue") }}',
                                data: yearlySaleData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 1
                            },
                            {
                                label: '{{ __("Total Revenue") }}',
                                data: totalYearlyData,
                                type: 'line',
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Yearly Revenue Chart canvas element not found');
            }
        } catch (e) {
            console.error('Error initializing Yearly Revenue Chart:', e);
        }
        @endif

    });
</script>
@endsection

@section('js')
<!-- Xuất dữ liệu sang file Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportExcel() {
        // Check if there's any data to export
        const hasDaily = document.querySelectorAll('#dailyRevenueTable tbody tr td:not(.text-center)').length > 0;
        const hasWeekly = document.querySelectorAll('#weeklyRevenueTable tbody tr td:not(.text-center)').length > 0;
        const hasMonthly = document.querySelectorAll('#monthlyRevenueTable tbody tr').length > 0;
        const hasYearly = document.querySelectorAll('#yearlyRevenueTable tbody tr').length > 0;

        if (!hasDaily && !hasWeekly && !hasMonthly && !hasYearly) {
            Swal.fire({
                icon: 'warning',
                title: "{{ __('Not Found') }}",
                text: "{{ __('No Data') }}",
                confirmButtonText: 'OK'
            });
            return;
        }

        // Get data from tables
        const dailyData = [];
        const weeklyData = [];
        const monthlyData = [];
        const yearlyData = [];

        // Process daily revenue
        document.querySelectorAll('#dailyRevenueTable tbody tr').forEach(row => {
            const cells = row.cells;
            if (cells.length > 1) {
                dailyData.push({
                    'Date': cells[0].textContent,
                    'Revenue': cells[1].textContent
                });
            }
        });

        // Process weekly revenue
        document.querySelectorAll('#weeklyRevenueTable tbody tr').forEach(row => {
            const cells = row.cells;
            if (cells.length > 1) {
                weeklyData.push({
                    'Week': cells[0].textContent,
                    'Start Date': cells[1].textContent,
                    'End Date': cells[2].textContent,
                    'Revenue': cells[3].textContent
                });
            }
        });

        // Process monthly revenue
        document.querySelectorAll('#monthlyRevenueTable tbody tr').forEach(row => {
            const cells = row.cells;
            if (cells.length > 1) {
                monthlyData.push({
                    'Month': cells[0].textContent,
                    'Revenue': cells[1].textContent,
                    'Type': cells[2].textContent
                });
            }
        });

        // Process yearly revenue
        document.querySelectorAll('#yearlyRevenueTable tbody tr').forEach(row => {
            const cells = row.cells;
            if (cells.length > 1) {
                yearlyData.push({
                    'Year': cells[0].textContent,
                    'Revenue': cells[1].textContent,
                    'Type': cells[2].textContent
                });
            }
        });

        // Create workbook
        const wb = XLSX.utils.book_new();

        // Add worksheets
        if (dailyData.length > 0) {
            const ws1 = XLSX.utils.json_to_sheet(dailyData);
            XLSX.utils.book_append_sheet(wb, ws1, "Daily Revenue");
        }

        if (weeklyData.length > 0) {
            const ws2 = XLSX.utils.json_to_sheet(weeklyData);
            XLSX.utils.book_append_sheet(wb, ws2, "Weekly Revenue");
        }

        if (monthlyData.length > 0) {
            const ws3 = XLSX.utils.json_to_sheet(monthlyData);
            XLSX.utils.book_append_sheet(wb, ws3, "Monthly Revenue");
        }

        if (yearlyData.length > 0) {
            const ws4 = XLSX.utils.json_to_sheet(yearlyData);
            XLSX.utils.book_append_sheet(wb, ws4, "Yearly Revenue");
        }

        // Get date range for filename
        const startDate = document.getElementById('start_date').value || 'all';
        const endDate = document.getElementById('end_date').value || 'all';

        // Export file
        XLSX.writeFile(wb, `revenue_report_${startDate}_to_${endDate}.xlsx`);

        console.log('Exported to Excel');
    }
</script>

<!-- Tìm kiếm và lọc sản phẩm -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM loaded, initializing product filters");

        // Make sure jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error("jQuery is not loaded!");
            return;
        }

        console.log("jQuery is loaded:", $.fn.jquery);

        // Debug: Log all products and their category IDs to console
        const rows = document.querySelectorAll("#product-table tr");
        console.log("Found", rows.length, "product rows");

        rows.forEach(row => {
            const categoryTd = row.querySelector("td[data-category-id]");
            if (categoryTd) {
                console.log("Product with category ID:", categoryTd.getAttribute("data-category-id"));
            }
        });

        // Apply filters function that handles both search and category filter
        function applyFilters() {
            const categoryFilter = document.getElementById("filter-category").value;
            const searchFilter = document.getElementById("search").value.toLowerCase();

            console.log("Applying filters - Category:", categoryFilter, "Search:", searchFilter);

            rows.forEach(row => {
                let categoryMatch = true;
                let searchMatch = true;

                // Category filtering
                if (categoryFilter) {
                    const categoryCell = row.querySelector("td[data-category-id]");
                    const categoryId = categoryCell ? categoryCell.getAttribute("data-category-id") : null;
                    categoryMatch = categoryId === categoryFilter;
                }

                // Search filtering
                if (searchFilter) {
                    searchMatch = row.textContent.toLowerCase().includes(searchFilter);
                }

                // Show/hide row based on combined filters
                if (categoryMatch && searchMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Apply filters when search input changes
        document.getElementById("search").addEventListener("keyup", applyFilters);

        // Apply filters when category changes (removed the Apply button)
        document.getElementById("filter-category").addEventListener("change", applyFilters);

        // Reset filters
        document.getElementById("reset-filter").addEventListener("click", function() {
            document.getElementById("filter-category").value = "";
            document.getElementById("search").value = "";
            rows.forEach(row => row.style.display = "");
        });
    });
</script>
@endsection