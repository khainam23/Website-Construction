@extends('admin.layouts.master')

@section('title', __('Edit Product'))

@section('content')
    <div class="container">
        <h1>{{ __('Edit Product') }}</h1>

        <form id="createForm" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="">
            </div>

            <div class="form-group">
                <label for="category_id">{{ __('Category') }}</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">{{ __('Description') }}</label>
                <textarea style="min-height: 130px;" name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="info">Thông tin</label>
                <textarea style="min-height: 130px;" name="info" id="info" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="feature">Tính năng</label>
                <textarea style="min-height: 130px;" name="feature" id="feature" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="application">Ứng dụng</label>
                <textarea style="min-height: 130px;" name="application" id="application" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="price">{{ __('Price') }}</label>
                <input type="number" name="price" id="price" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label for="stock">{{ __('Stock') }}</label>
                <input type="number" name="stock" id="stock" class="form-control" value="1">
            </div>

            <div class="form-group">
                <label for="images">{{ __('Images') }}</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
@endsection

@section('js')
    <!-- Thêm sản phẩm -->
    <script>
        $(document).ready(function () {
            $('#createForm').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route("admin.api.product.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Đang xử lý...',
                            text: 'Vui lòng chờ trong giây lát!',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Sản phẩm đã được thêm thành công!',
                        }).then(() => {
                            window.location.href = '{{ route("admin.products.index") }}';
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = 'Có lỗi xảy ra!';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage,
                        });
                    }
                });
            });
        });
    </script>
@endsection