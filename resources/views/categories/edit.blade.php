<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }
        .upload-area:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
        .current-image {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .cropper-container {
            max-width: 100%;
            margin: 1rem 0;
        }
        .cropper-modal {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .cropper-view-box {
            border-radius: 8px;
        }
        .cropper-face {
            background-color: inherit;
        }
        .cropper-line, .cropper-point {
            background-color: #0d6efd;
        }
        .cropper-bg {
            background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #ccc 75%), linear-gradient(-45deg, transparent 75%, #ccc 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="form-container">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Edit Category
                        </h4>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="category_name" class="form-label">
                                <i class="fas fa-tag me-1"></i>Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('category_name') is-invalid @enderror" 
                                   id="category_name" 
                                   name="category_name" 
                                   value="{{ old('category_name', $category->category_name) }}" 
                                   placeholder="Enter category name"
                                   required>
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label">
                                <i class="fas fa-level-up-alt me-1"></i>Parent Category
                            </label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" 
                                    id="parent_id" 
                                    name="parent_id">
                                <option value="">Select parent category (optional)</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" 
                                            {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-image me-1"></i>Category Image
                            </label>
                            
                            @if($category->category_image)
                                <div class="current-image mb-3">
                                    <p class="mb-2"><strong>Current Image:</strong></p>
                                    <img src="{{ asset('storage/' . $category->category_image) }}" 
                                         alt="{{ $category->category_name }}" 
                                         class="image-preview">
                                </div>
                            @endif
                            
                            <div class="upload-area" onclick="document.getElementById('category_image').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Click to upload new image</p>
                                <small class="text-muted">Supports: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <input type="file" 
                                   class="form-control d-none @error('category_image') is-invalid @enderror" 
                                   id="category_image" 
                                   name="category_image" 
                                   accept="image/*"
                                   onchange="handleImageUpload(this)">
                            @error('category_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-3 text-center">
                                <img id="image_preview" class="image-preview" alt="Preview" style="display: none;">
                            </div>
                            
                            <div id="cropperContainer" class="mt-3" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Crop & Resize Image</h6>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" onclick="cropImage()">
                                            <i class="fas fa-crop me-1"></i>Crop & Save
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="cancelCrop()">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                    </div>
                                </div>
                                <div class="cropper-container">
                                    <img id="cropperImage" src="" alt="Crop Image" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save me-2"></i>Update Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        let cropper = null;
        let originalFile = null;

        function handleImageUpload(input) {
            const file = input.files[0];
            if (!file) return;

            originalFile = file;
            
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image_preview');
                const cropperImage = document.getElementById('cropperImage');
                const cropperContainer = document.getElementById('cropperContainer');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                cropperImage.src = e.target.result;
                cropperContainer.style.display = 'block';
                
                initCropper();
            }
            reader.readAsDataURL(file);
        }

        function initCropper() {
            const image = document.getElementById('cropperImage');
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 2,
                dragMode: 'move',
                autoCropArea: 1,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        }

        function cropImage() {
            if (!cropper) return;
            
            cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            }).toBlob(function(blob) {
                const file = new File([blob], originalFile.name, {
                    type: originalFile.type,
                    lastModified: Date.now()
                });
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('category_image').files = dataTransfer.files;
                
                const preview = document.getElementById('image_preview');
                preview.src = URL.createObjectURL(blob);
                
                cancelCrop();
            }, originalFile.type, 0.9);
        }

        function cancelCrop() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            document.getElementById('cropperContainer').style.display = 'none';
        }

        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('category_image');
            if (fileInput.files.length === 0) {
                return;
            }
            
            if (cropper) {
                e.preventDefault();
                cropImage();
                setTimeout(() => {
                    document.getElementById('categoryForm').submit();
                }, 100);
            }
        });
    </script>
</body>
</html> 