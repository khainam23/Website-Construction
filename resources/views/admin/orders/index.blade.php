@extends('admin.layouts.master')

@section('title', __('Order Management'))

@section('css')
<style>
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0.15rem 0.35rem rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .filter-card:hover {
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.08);
    }
    
    .filter-card .card-body {
        padding: 1.5rem;
    }
    
    .filter-input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        display: flex;
        background: white;
        border: 1px solid #e0e0e0;
    }
    
    .search-input {
        flex-grow: 1;
        border: none;
        border-radius: 0;
        padding-left: 1rem;
        padding-right: 1rem;
        height: 45px;
        font-size: 0.95rem;
    }
    
    .search-input:focus {
        box-shadow: none;
        border-color: transparent;
    }
    
    .filter-select {
        border: none;
        border-left: 1px solid #e0e0e0;
        border-radius: 0;
        width: 200px;
        padding-left: 15px;
        height: 45px;
        font-size: 0.95rem;
        background-position: right 15px center;
    }
    
    .filter-select:focus {
        box-shadow: none;
        border-color: #e0e0e0;
    }
    
    .reset-button {
        border: none;
        border-left: 1px solid #e0e0e0;
        border-radius: 0;
        padding: 0.5rem 1.25rem;
        background-color: #f1f1f1;
        transition: all 0.2s;
        font-weight: 500;
    }
    
    .reset-button:hover {
        background-color: #e2e6ea;
    }
    
    .filter-input-group i {
        color: #6c757d;
    }
    
    .filter-icon-wrapper {
        display: flex;
        align-items: center;
        padding: 0 15px;
        border-right: 1px solid #e0e0e0;
        background-color: #f8f9fa;
    }

    .search-input-group {
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        border-radius: 8px 0 0 8px;
        overflow: hidden;
        transition: all 0.2s;
    }
    
    .search-input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }
    
    .filter-select {
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.2s;
        border-radius: 0;
    }
    
    .filter-select:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }
    
    .reset-button {
        border-radius: 0 8px 8px 0;
    }
    
    .active-filter {
        background-color: #e8f0fe;
        font-weight: 500;
    }
    
    .filter-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .orders-table {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .orders-table thead {
        background-color: #f1f5f9;
    }
    
    .orders-table th {
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .order-item-list {
        max-height: 120px;
        overflow-y: auto;
        padding-right: 5px;
        list-style-type: none;
        padding-left: 0;
    }
    
    .order-item {
        padding: 4px 8px;
        margin-bottom: 4px;
        border-bottom: 1px solid #e9ecef;
        font-size: 0.85rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.85em;
    }
    
    .action-btn {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Simplified filter styles to match product page */
    .input-group {
        margin-bottom: 1rem;
    }
    
    .input-group .form-control {
        border-radius: 0.25rem 0 0 0.25rem;
    }
    
    .input-group .form-select {
        max-width: 200px;
        border-left: 0;
        border-radius: 0;
    }
    
    .input-group .btn-outline-secondary {
        border-radius: 0 0.25rem 0.25rem 0;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('Order Management') }}</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" 
                               placeholder="{{ __('Search by Order ID, Customer Name...') }}" value="">
                        <select id="filter-status" class="form-select" style="max-width: 200px;">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-secondary" type="button" id="reset-filter">{{ __('Reset') }}</button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Contact Info') }}</th>
                                <th>{{ __('Items') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="orders-table">
                            @foreach($orders as $order)
                            <tr data-status="{{ $order->status }}">
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td data-user-name="{{ $order->user->first_name }} {{ $order->user->last_name }}">
                                    <div>{{ $order->user->first_name }} {{ $order->user->last_name }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($order->calculated_total, 0, ',', '.') }} đ</span>
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge bg-secondary',
                                            'confirm' => 'badge bg-primary',
                                            'ship' => 'badge bg-warning text-dark',
                                            'delivery' => 'badge bg-success',
                                            'return' => 'badge bg-info text-dark',
                                            'cancel' => 'badge bg-danger',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'badge bg-dark';
                                    @endphp

                                    <span class="{{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div><i class="fas fa-map-marker-alt me-1"></i> {{ $order->address }}</div>
                                    <div><i class="fas fa-phone me-1"></i> {{ $order->phone }}</div>
                                </td>
                                <td>
                                    <div class="order-item-list">
                                        @foreach($order->details as $detail)
                                            <div class="order-item">
                                                <strong>{{ $detail->product->name }}</strong> × {{ $detail->quantity }}
                                                <div class="text-muted small">{{ number_format($detail->cost * $detail->quantity, 0, ',', '.') }} đ</div>
                                                @if($detail->rental_start_date && $detail->rental_end_date)
                                                    <div class="small text-primary">
                                                        <i class="far fa-calendar-alt me-1"></i> 
                                                        {{ $detail->rental_start_date }} → {{ $detail->rental_end_date }}
                                                        @if($detail->duration)
                                                            ({{ $detail->duration }})
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-primary action-btn">
                                        <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM loaded, initializing order filters");
            
            // Make sure jQuery is loaded
            if (typeof jQuery === 'undefined') {
                console.error("jQuery is not loaded!");
                return;
            }
            
            const rows = document.querySelectorAll("#orders-table tr");
            console.log("Found", rows.length, "order rows");
            
            // Apply filters function that handles both search and status filter
            function applyFilters() {
                const statusFilter = document.getElementById("filter-status").value.toLowerCase();
                const searchFilter = document.getElementById("search").value.toLowerCase();
                
                console.log("Applying filters - Status:", statusFilter, "Search:", searchFilter);
                
                rows.forEach(row => {
                    let statusMatch = true;
                    let searchMatch = true;
                    
                    // Status filtering
                    if (statusFilter) {
                        const rowStatus = row.getAttribute("data-status");
                        statusMatch = rowStatus === statusFilter;
                    }
                    
                    // Search filtering - look in ID and customer name
                    if (searchFilter) {
                        const id = row.querySelector("td:first-child").textContent.toLowerCase();
                        const userName = row.querySelector("td[data-user-name]").getAttribute("data-user-name").toLowerCase();
                        searchMatch = id.includes(searchFilter) || userName.includes(searchFilter);
                    }
                    
                    // Show/hide row based on combined filters
                    if (statusMatch && searchMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
            
            // Apply filters when search input changes
            document.getElementById("search").addEventListener("keyup", applyFilters);
            
            // Apply filters when status changes
            document.getElementById("filter-status").addEventListener("change", applyFilters);
            
            // Reset filters
            document.getElementById("reset-filter").addEventListener("click", function() {
                document.getElementById("filter-status").value = "";
                document.getElementById("search").value = "";
                rows.forEach(row => row.style.display = "");
            });
        });
    </script>
@endsection