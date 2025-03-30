@extends('sale.layouts.master')

@section('title', __('Product Management'))

@section('styles')
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="container">
        <h1>{{ __('Product Management') }}</h1>

        <div class="mb-3">
            <div class="input-group">
                <input id="search" type="text" class="form-control" placeholder="{{ __('Search') }}" name="search" value="{{ request('search') }}">
                <select id="filter-category" class="form-select" style="max-width: 200px;">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-secondary" type="button" id="reset-filter">{{ __('Reset') }}</button>
            </div>

            <!-- Hiển thị sản phẩm -->
            <div id="search-results">
            </div>
        </div>

        <div class="mb-2 d-flex">
            <a href="{{ route('sale.products.create') }}" class="btn btn-primary" id="add-product">{{ __('Add Product') }}</a>
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
                    @for($i = $page * 10 - 10; $i < $page * 10 && $i < count($products); $i++)
                        @php
                            $product = $products[$i]
                        @endphp
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td data-category-id="{{ $product->category_id }}">{{ $product->category->name }}</td>
                            <td data-price="{{ $product->price }}">{{ $product->price }}</td>
                            <td data-stock="{{ $product->productInventories ? $product->productInventories->quantity : 0 }}">{{ $product->productInventories ? $product->productInventories->quantity : 0 }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($product->avatar)
                                    <img src="{{ asset($product->avatar) }}" class="img-fluid" alt="{{ $product->name }}"
                                        style="max-height: 100px; width: 100px; object-fit: contain;">
                                @else
                                    {{ __('No Images') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sale.products.edit', $product->id) }}"
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
                    @endfor
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    @php
                        $totalPages = ceil(count($products) / 10);
                    @endphp

                    <li class="page-item {{ ($page == 1) ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('sale.products.index', ['page' => max(1, $page - 1)]) }}" tabindex="-1">
                            <</a>
                    </li>

                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ ($page == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('sale.products.index', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ ($page == $totalPages) ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('sale.products.index', ['page' => min($totalPages, $page + 1)]) }}">></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function exportExcel() {
            let products = @json($products);

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

            let ws = XLSX.utils.json_to_sheet(data);
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Danh sách sản phẩm");
            XLSX.writeFile(wb, "products.xlsx");
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM loaded, initializing product filters");
            
            if (typeof jQuery === 'undefined') {
                console.error("jQuery is not loaded!");
                return;
            }
            
            console.log("jQuery is loaded:", $.fn.jquery);
            
            const rows = document.querySelectorAll("#product-table tr");
            console.log("Found", rows.length, "product rows");
            
            rows.forEach(row => {
                const categoryTd = row.querySelector("td[data-category-id]");
                if (categoryTd) {
                    console.log("Product with category ID:", categoryTd.getAttribute("data-category-id"));
                }
            });
            
            function applyFilters() {
                const categoryFilter = document.getElementById("filter-category").value;
                const searchFilter = document.getElementById("search").value.toLowerCase();
                
                console.log("Applying filters - Category:", categoryFilter, "Search:", searchFilter);
                
                rows.forEach(row => {
                    let categoryMatch = true;
                    let searchMatch = true;
                    
                    if (categoryFilter) {
                        const categoryCell = row.querySelector("td[data-category-id]");
                        const categoryId = categoryCell ? categoryCell.getAttribute("data-category-id") : null;
                        categoryMatch = categoryId === categoryFilter;
                    }
                    
                    if (searchFilter) {
                        searchMatch = row.textContent.toLowerCase().includes(searchFilter);
                    }
                    
                    if (categoryMatch && searchMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
            
            document.getElementById("search").addEventListener("keyup", applyFilters);
            document.getElementById("filter-category").addEventListener("change", applyFilters);
            
            document.getElementById("reset-filter").addEventListener("click", function() {
                document.getElementById("filter-category").value = "";
                document.getElementById("search").value = "";
                rows.forEach(row => row.style.display = "");
            });
        });
    </script>
@endsection
