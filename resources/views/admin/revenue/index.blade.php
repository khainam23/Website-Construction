@extends('admin.layouts.master')

@section('title', __('Revenue Statistics'))

@section('styles')
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
            <div class="table-responsive">
                <table class="table table-striped" id="dailyRevenueTable">
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
            <div class="table-responsive">
                <table class="table table-striped" id="weeklyRevenueTable">
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
            <div class="table-responsive">
                <table class="table table-striped" id="monthlyRevenueTable">
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
            <div class="table-responsive">
                <table class="table table-striped" id="yearlyRevenueTable">
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

@section('js')
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
@endsection