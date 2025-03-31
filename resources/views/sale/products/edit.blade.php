@extends('sale.layouts.master')

@section('title', __('Edit Product'))

@section('styles')
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .image-container {
            transition: all 0.3s ease;
            position: relative;
        }
        .image-container:hover {
            transform: translateY(-5px);
        }
        .image-container img {
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .image-container .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.5);
            color: white;
            opacity: 0;
            transition: all 0.3s;
            border-radius: 5px;
        }
        .image-container:hover .overlay {
            opacity: 1;
        }
        .image-container .delete-image {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: 14px;
            z-index: 10;
        }
        .marked-for-deletion img {
            filter: grayscale(100%);
        }
        .marked-for-deletion .deletion-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(220, 53, 69, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            z-index: 5;
        }
        #tempImagePreview {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        button[type="submit"] {
            padding: 10px 25px;
            font-weight: 600;
        }
        textarea {
            resize: vertical;
        }
        .avatar-badge {
            position: absolute;
            bottom: 5px;
            left: 5px;
            z-index: 5;
        }
        .avatar-actions {
            position: absolute;
            bottom: 5px;
            left: 5px;
            z-index: 5;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .image-container:hover .avatar-actions {
            opacity: 1;
        }
        .image-container.is-avatar {
            border: 2px solid #0d6efd;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ __('Edit Product') }}</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form id="updateForm" action="{{ route('admin.api.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea style="min-height: 100px;" name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="info">Thông tin</label>
                                <textarea style="min-height: 150px;" name="info" id="info" class="form-control">{{ $product->info }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="feature">Tính năng</label>
                                <textarea style="min-height: 150px;" name="feature" id="feature" class="form-control">{{ $product->features }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="application">Ứng dụng</label>
                                <textarea style="min-height: 150px;" name="application" id="application" class="form-control">{{ $product->applications }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">{{ __('Price') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₫</span>
                                    </div>
                                    <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">{{ __('Stock') }}</label>
                                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->productInventories->quantity }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="images">{{ __('Add New Images') }}</label>
                        <div class="custom-file">
                            <input type="file" name="images[]" id="images" class="custom-file-input" multiple>
                            <label class="custom-file-label" for="images">Choose files</label>
                        </div>
                        <small class="form-text text-muted">Maximum 5MB per image. Supported formats: JPG, JPEG, PNG, GIF, WEBP</small>
                    </div>

                    <hr>
                    <h5 class="mb-3">{{ __('Current Product Images') }}</h5>
                    <!-- Khu vực hiển thị ảnh -->
                    <div id="imagePreview" class="mb-4">
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-6 col-md-3 mb-4 image-container {{ $product->avatar == $image->path ? 'is-avatar' : '' }}" data-id="{{ $image->id }}">
                                    <div class="position-relative h-100">
                                        <img src="{{ asset($image->path) }}" alt="{{ $product->name }}" 
                                             class="img-thumbnail w-100 h-100" style="object-fit: cover;">
                                        <button class="btn btn-danger btn-sm delete-image"
                                                data-image-id="{{ $image->id }}">
                                            &times;
                                        </button>
                                        
                                        @if($product->avatar == $image->path)
                                            <span class="badge bg-primary avatar-badge">{{ __('Avatar') }}</span>
                                        @else
                                            <div class="avatar-actions">
                                                <button type="button" class="btn btn-primary btn-sm set-avatar" 
                                                        data-image-id="{{ $image->id }}" data-product-id="{{ $product->id }}">
                                                    {{ __('Set as Avatar') }}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('sale.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Update Product') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <!-- Set image as avatar -->
    <script>
        $(document).ready(function() {
            $('.set-avatar').on('click', function(e) {
                e.preventDefault();
                
                const imageId = $(this).data('image-id');
                const productId = $(this).data('product-id');
                const button = $(this);
                
                Swal.fire({
                    title: "{{ __('Set as Avatar') }}?",
                    text: "{{ __('Do you want to set this image as the product avatar?') }}",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, set as avatar') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.api.product.set.avatar') }}",
                            type: "POST",
                            data: {
                                image_id: imageId,
                                product_id: productId,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update UI to show new avatar
                                    $('.is-avatar').removeClass('is-avatar');
                                    $('.avatar-badge').remove();
                                    $('.avatar-actions').removeClass('d-none');
                                    
                                    // Update current image as avatar
                                    const container = button.closest('.image-container');
                                    container.addClass('is-avatar');
                                    container.find('.avatar-actions').replaceWith('<span class="badge bg-primary avatar-badge">{{ __("Avatar") }}</span>');
                                    
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: '{{ __("Avatar updated successfully") }}',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true
                                    });
                                } else {
                                    Swal.fire("{{ __('Error!') }}", response.message, "error");
                                }
                            },
                            error: function(xhr) {
                                Swal.fire("{{ __('Error!') }}", "{{ __('Failed to update avatar') }}", "error");
                                console.error(xhr);
                            }
                        });
                    }
                });
            });
        });
    </script>
    
    <!-- Xóa ảnh con của sản phẩm -->
    <script>
        $(document).ready(function () {
            // Keep track of images to delete
            let imagesToDelete = [];
            
            $(".delete-image").on("click", function (event) {
                event.preventDefault();

                let imageId = $(this).data("image-id");
                let imageContainer = $(this).closest(".image-container");

                // Ask for confirmation to mark for deletion
                Swal.fire({
                    title: "Đánh dấu ảnh này để xóa?",
                    text: "Ảnh sẽ được xóa khi bạn lưu sản phẩm.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Đánh dấu xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add to list of images to delete
                        imagesToDelete.push(imageId);
                        
                        // Change appearance to indicate pending deletion
                        imageContainer.addClass('marked-for-deletion');
                        imageContainer.find('img').addClass('opacity-50');
                        imageContainer.append('<div class="deletion-badge">Đánh dấu xóa</div>');
                        
                        // Change delete button to undo button
                        $(this).removeClass('btn-danger').addClass('btn-warning').html('<i class="fas fa-undo"></i>');
                        $(this).off('click').on('click', function(e) {
                            e.preventDefault();
                            
                            // Remove from delete list
                            imagesToDelete = imagesToDelete.filter(id => id !== imageId);
                            
                            // Restore appearance
                            imageContainer.removeClass('marked-for-deletion');
                            imageContainer.find('img').removeClass('opacity-50');
                            imageContainer.find('.deletion-badge').remove();
                            
                            // Restore delete button
                            $(this).removeClass('btn-warning').addClass('btn-danger').text('×');
                            $(this).off('click');
                            
                            // Re-attach original click handler
                            $(this).on('click', arguments.callee.caller.arguments[0].handleObj.handler);
                        });
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Đã đánh dấu xóa',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true
                        });
                    }
                });
            });

            // Custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = '';
                if (this.files && this.files.length > 1) {
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                } else {
                    fileName = this.files[0].name;
                }
                
                if(fileName) {
                    $(this).next('.custom-file-label').html(fileName);
                }
            });
            
            // Combined form submission handler
            $('#updateForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                
                // Add list of images to delete
                imagesToDelete.forEach((imageId) => {
                    formData.append('delete_images[]', imageId);
                });

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
                        let errorMsg = "Lỗi khi cập nhật sản phẩm. Vui lòng thử lại.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        Swal.fire("Lỗi!", errorMsg, "error");
                        console.log(xhr);
                    }
                });
            });
        });
    </script>

    <!-- Thêm hình ảnh cho sản phẩm -->
    <script>
        $(document).ready(function () {
            // Preview images before upload
            $('#images').on('change', function() {
                const fileInput = this;
                if (fileInput.files && fileInput.files.length > 0) {
                    // Create temporary preview area if not exists
                    let tempPreviewArea = $('#tempImagePreview');
                    if (tempPreviewArea.length === 0) {
                        $('#imagePreview .row').after('<div id="tempImagePreview" class="row mt-3 border-top pt-3"><h6 class="col-12">Ảnh mới sẽ được tải lên:</h6></div>');
                        tempPreviewArea = $('#tempImagePreview');
                    } else {
                        tempPreviewArea.empty();
                        tempPreviewArea.append('<h6 class="col-12">Ảnh mới sẽ được tải lên:</h6>');
                    }
                    
                    // Show preview for each selected file
                    for (let i = 0; i < fileInput.files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            tempPreviewArea.append(`
                                <div class="col-3 mb-3">
                                    <div class="position-relative">
                                        <img src="${e.target.result}" class="img-thumbnail w-100" 
                                            style="max-height: 100px; object-fit: cover;">
                                    </div>
                                </div>
                            `);
                        }
                        reader.readAsDataURL(fileInput.files[i]);
                    }
                }
            });

            $('#images').on('change', function (event) {
                let files = event.target.files;
                if (files.length === 0) return;

                let formData = new FormData();
                let allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
                let maxSize = 5 * 1024 * 1024; // 5MB
                let hasError = false;

                for (let file of files) {
                    let fileExt = file.name.split('.').pop().toLowerCase();
                    if (!allowedExtensions.includes(fileExt)) {
                        Swal.fire("Lỗi!", `Định dạng <b>${fileExt}</b> không được hỗ trợ! Chỉ chấp nhận: ${allowedExtensions.join(', ')}`, "error");
                        $(this).val(''); // Reset file input
                        $('#tempImagePreview').remove();
                        hasError = true;
                        break;
                    }
                    if (file.size > maxSize) {
                        Swal.fire("Lỗi!", `File <b>${file.name}</b> quá lớn! Chỉ cho phép tối đa 5MB.`, "error");
                        $(this).val(''); // Reset file input
                        $('#tempImagePreview').remove();
                        hasError = true;
                        break;
                    }
                    formData.append('images[]', file);
                }

                if (hasError) return;

                formData.append('product_id', "{{ $product->id }}");
                
                // Ask for confirmation before uploading
                Swal.fire({
                    title: "Bạn có chắc chắn muốn tải lên các ảnh này?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Tải lên",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
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
                            error: function (xhr) {
                                let errorMsg = "Lỗi khi tải ảnh lên. Vui lòng thử lại.";
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                                }
                                Swal.fire("Lỗi!", errorMsg, "error");
                            }
                        });
                    } else {
                        $(this).val(''); // Reset file input if canceled
                        $('#tempImagePreview').remove();
                    }
                });
            });
        });
    </script>
@endsection