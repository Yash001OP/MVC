<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            display: none;
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
        .description-counter {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="form-container">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-plus me-2"></i>
                            Create New Product
                        </h4>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
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

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">
                                        <i class="fas fa-box me-1"></i>Product Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('product_name') is-invalid @enderror" 
                                           id="product_name" 
                                           name="product_name" 
                                           value="{{ old('product_name') }}" 
                                           placeholder="Enter product name"
                                           required>
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">
                                        <i class="fas fa-tags me-1"></i>Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" 
                                            name="category_id" 
                                            required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="product_description" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Product Description <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('product_description') is-invalid @enderror" 
                                              id="product_description" 
                                              name="product_description" 
                                              rows="6" 
                                              placeholder="Enter detailed product description..."
                                              required
                                              oninput="updateCharCount(this)">{{ old('product_description') }}</textarea>
                                    <div class="description-counter mt-1">
                                        <span id="charCount">0</span> characters
                                    </div>
                                    @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-image me-1"></i>Product Image
                                    </label>
                                    <div class="upload-area" onclick="document.getElementById('product_image').click()">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                        <p class="mb-1">Click to upload image</p>
                                        <small class="text-muted">Supports: JPG, PNG, GIF (Max: 2MB)</small>
                                    </div>
                                    <input type="file" 
                                           class="form-control d-none @error('product_image') is-invalid @enderror" 
                                           id="product_image" 
                                           name="product_image" 
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    @error('product_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-3 text-center">
                                        <img id="image_preview" class="image-preview" alt="Preview">
                                    </div>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-1"></i>Tips
                                        </h6>
                                        <ul class="card-text small mb-0">
                                            <li>Use descriptive product names</li>
                                            <li>Include key features in description</li>
                                            <li>Upload high-quality images</li>
                                            <li>Select appropriate category</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Create Product
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        function updateCharCount(textarea) {
            const charCount = document.getElementById('charCount');
            charCount.textContent = textarea.value.length;
        }

        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('product_description');
            if (textarea) {
                updateCharCount(textarea);
            }
        });
    </script>
</body>
</html> 