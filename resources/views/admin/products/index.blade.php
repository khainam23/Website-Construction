@php
    $layout = session('user')['role'] == 'admin' ? 'admin.layouts.master' : 'sale.layouts.master';
@endphp

@extends($layout)

@section('title', __('Product Management'))

@section('content')
    <div class="container">
        <h1>{{ __('Product Management') }}</h1>

        <div class="mb-3">
            <div class="input-group">
                <input id="search" type="text" class="form-control" placeholder="{{ __('Search') }}" name="search"
                    value="{{ request('search') }}">
            </div>

            <!-- Hiển thị sản phẩm -->
            <div id="search-results">
            </div>
        </div>

        <div class="mb-2 d-flex">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary"
                id="add-product">{{ __('Add Product') }}</a>
            <button class="btn btn-success ml-3" onclick="exportExcel()">{{ __('Export File') }}</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th style="text-align: center; vertical-align: middle;">{{ __('Images') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->productInventories ? $product->productInventories->quantity : 0 }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($product->avatar)
                                    <img src="{{ $product->avatar }}" class="img-fluid" alt="{{ $product->name }}"
                                        style="max-height: 100px; width: 100px; object-fit: contain;">
                                @else
                                    {{ __('No Images') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')

    <!-- Xuất dữ liệu sang file Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function exportExcel() {
            // Dữ liệu từ Laravel Blade
            let products = @json($products);
            products = products.data;

            // Chuyển đổi dữ liệu thành mảng JSON
            let data = products.map((product, index) => ({
                'ID': product.id,
                'Name': product.name,
                'Category': product.category.name,
                'Price': product.price,
                'Stock': product.product_inventories?.quantity,
                'Avatar': product.avatar,
                'Status': product.status,
                'Created At': product.created_at,
                'Updated At': product.updated_at,
                'Type': product.type,
                'Description': product.description,
            }));

            // Tạo một worksheet từ mảng JSON
            let ws = XLSX.utils.json_to_sheet(data);

            // Tạo workbook và thêm worksheet
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Danh sách sản phẩm");

            // Xuất file Excel
            XLSX.writeFile(wb, "products.xlsx");
        }
    </script>

    <!-- Tìm kiếm sản phẩm -->
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#product-table tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>

@endsection