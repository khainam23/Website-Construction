@extends('sale.layouts.master')

@section('title', __('Edit Product'))

@section('content')
    <div class="container">
        <h1>{{ __('Edit Product') }}</h1>

        <form id="updateForm" action="{{ route('admin.api.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

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
            </div>

            <!-- Khu vực hiển thị ảnh -->
            <div id="imagePreview" class="mt-3 container">
                <div class="row">
                    @foreach($product->images as $image)
                        <div class="col-3 mb-3 image-container" data-id="{{ $image->id }}">
                            <div class="position-relative">
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" class="img-thumbnail w-100"
                                    style="max-height: 100px; object-fit: cover;">
                                <button class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image"
                                    data-image-id="{{ $image->id }}">
                                    &times;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('sale.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".delete-image").on("click", function (event) {
                event.preventDefault();

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

            $('#images').on('change', function (event) {
                let files = event.target.files;
                if (files.length === 0) return;

                let formData = new FormData();
                let allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                let maxSize = 5 * 1024 * 1024; // 5MB

                for (let file of files) {
                    let fileExt = file.name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExt)) {
                        Swal.fire("Lỗi!", `Định dạng <b>${fileExt}</b> không được hỗ trợ!`, "error");
                        return;
                    }
                    if (file.size > maxSize) {
                        Swal.fire("Lỗi!", `File <b>${file.name}</b> quá lớn! Chỉ cho phép tối đa 5MB.`, "error");
                        return;
                    }
                    formData.append('images[]', file);
                }

                formData.append('product_id', "{{ $product->id }}");

                Swal.fire({
                    title: "Đang tải ảnh lên...",
                    text: "Vui lòng chờ trong giây lát!",
                    icon: "info",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('admin.api.product.upload.images') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                title: "Thành công!",
                                text: "Ảnh đã được tải lên!",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Lỗi!", data.error || "Không xác định", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire("Lỗi!", "Lỗi khi tải ảnh lên. Vui lòng thử lại.", "error");
                    }
                });
            });

            $('#updateForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Đang cập nhật...",
                            text: "Vui lòng đợi!",
                            icon: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Thành công!",
                                text: "Thông tin sản phẩm đã được cập nhật!",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Lỗi!", response.error || "Không xác định", "error");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection