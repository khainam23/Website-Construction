@extends('admin.layouts.master')

@section('title', __('Order Management'))

@section('content')
    <div class="container">
        <h1>{{ __('Order Management') }}</h1>

        <div class="mb-3">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ __('Search') }}" name="search"
                        value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Items') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'badge bg-secondary',  // Chờ xử lý (màu xám)
                                                    'confirm' => 'badge bg-primary',    // Đã xác nhận (xanh dương)
                                                    'ship' => 'badge bg-warning text-dark',  // Đang giao hàng (vàng cam)
                                                    'delivery' => 'badge bg-success',   // Đã giao hàng (xanh lá)
                                                    'return' => 'badge bg-info text-dark', // Trả hàng (xanh nhạt)
                                                    'cancel' => 'badge bg-danger',      // Đã hủy (đỏ)
                                                ];
                                                $statusClass = $statusClasses[$order['status']] ?? 'badge bg-dark'; // Mặc định nếu trạng thái không hợp lệ
                                            @endphp

                                            <span class="{{ $statusClass }}">
                                                {{ ucfirst($order['status']) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>
                                            <ul>
                                                @foreach($order->details as $detail)
                                                    <li>
                                                        {{ $detail->product->name }} ({{ $detail->quantity }}) - {{ $detail->cost }}
                                                        @if($detail->rental_start && $detail->rental_end && $detail->duration)
                                                            <br>
                                                            {{ __('Rental Start') }}: {{ $detail->rental_start }}
                                                            {{ __('Rental End') }}: {{ $detail->rental_end }}
                                                            {{ __('Duration') }}: {{ $detail->duration }}
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-primary">{{ __('View') }}</a>
                                        </td>
                                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('js')
    <!-- Tìm kiếm sản phẩm -->
    <script>
        $(document).ready(function () {
            $("#searchInput").on("input", function () {
                let filter = $(this).val().toLowerCase();

                $("#ordersBody tr").each(function () {
                    let user = $(this).find("td:eq(1)").text().toLowerCase();
                    let products = $(this).find("td:eq(6)").text().toLowerCase();
                    $(this).toggle(user.includes(filter) || products.includes(filter));
                });
            });
        });
    </script>

@endsection