@extends('admin.layouts.master')

@section('title', __('Edit Product'))

@section('content')
    <div class="container">
        <h1>{{ __('Edit Product') }}</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
            </div>

            <div class="form-group">
                <label for="category_id">{{ __('Category') }}</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">{{ __('Description') }}</label>
                <textarea style="min-height: 130px;" name="description" id="description"
                    class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="info">Thông tin</label>
                <textarea style="min-height: 130px;" name="info" id="info"
                    class="form-control">{{ $product->info }}</textarea>
            </div>

            <div class="form-group">
                <label for="feature">Tính năng</label>
                <textarea style="min-height: 130px;" name="feature" id="feature"
                    class="form-control">{{ $product->features }}</textarea>
            </div>

            <div class="form-group">
                <label for="application">Ứng dụng</label>
                <textarea style="min-height: 130px;" name="application" id="application"
                    class="form-control">{{ $product->applications }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">{{ __('Price') }}</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label for="stock">{{ __('Stock') }}</label>
                <input type="number" name="stock" id="stock" class="form-control"
                    value="{{ $product->productInventories->quantity }}">
            </div>

            <div class="form-group">
                <label for="images">{{ __('Images') }}</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>

                @if($product->images)
                    <div class="mt-3 d-flex flex-wrap">
                        @foreach($product->images as $image)
                            <div class="position-relative m-2 mr-5">
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="img-thumbnail"
                                    style="max-height: 100px;">

                                <!-- Nút X để xóa -->
                                <button class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image"
                                    data-image-id="{{ $image->id }}">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
@endsection

@section('js')
    <!-- Xóa ảnh con của sản phẩm -->
    <script>
        $(document).ready(function () {
            $(".delete-image").on("click", function (event) {
                event.preventDefault(); // Ngăn form submit khi click vào nút xóa

                let imageId = $(this).data("image-id");
                let imageContainer = $(this).closest(".position-relative");

                Swal.fire({
                    title: "Bạn có chắc chắn muốn xóa ảnh này?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.api.product.delete.image', ':id') }}".replace(':id', imageId),
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            success: function (response) {
                                if (response.success) {
                                    imageContainer.remove();
                                    Swal.fire("Đã xóa!", "Ảnh đã được xóa thành công.", "success");
                                } else {
                                    Swal.fire("Lỗi!", "Không thể xóa ảnh.", "error");
                                }
                            },
                            error: function () {
                                Swal.fire("Lỗi!", "Có lỗi xảy ra khi xóa ảnh.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection