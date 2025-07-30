<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name }} - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 400px;
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .info-card {
            border-left: 4px solid #0d6efd;
        }
        .description-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            border-left: 4px solid #28a745;
        }
        .category-badge {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.index') }}" class="text-decoration-none">
                                    <i class="fas fa-box me-1"></i>Products
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $product->product_name }}
                            </li>
                        </ol>
                    </nav>
                    <div class="btn-group" role="group">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                @if($product->product_image)
                                    <img src="{{ asset('storage/' . $product->product_image) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="product-image mb-3">
                                @else
                                    <div class="product-image mb-3 bg-secondary d-flex align-items-center justify-content-center mx-auto">
                                        <i class="fas fa-image fa-3x text-white"></i>
                                    </div>
                                @endif
                                <h3 class="card-title">{{ $product->product_name }}</h3>
                                @if($product->category)
                                    <span class="badge category-badge text-white fs-6">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $product->category->category_name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm info-card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Product Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-box me-2"></i>Product Name:</strong>
                                        <p class="mb-0">{{ $product->product_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-id me-2"></i>Product ID:</strong>
                                        <p class="mb-0">#{{ $product->id }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-calendar me-2"></i>Created:</strong>
                                        <p class="mb-0">{{ $product->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-clock me-2"></i>Last Updated:</strong>
                                        <p class="mb-0">{{ $product->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($product->category)
                            <div class="card border-0 shadow-sm mt-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-tags me-2"></i>
                                        Category Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $product->category->category_name }}</h6>
                                            <small class="text-muted">Category ID: #{{ $product->category->id }}</small>
                                        </div>
                                        <a href="{{ route('categories.show', $product->category->id) }}" 
                                           class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>View Category
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-align-left me-2"></i>
                                    Product Description
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="description-box">
                                    <p class="mb-0">{{ $product->product_description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Product
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Delete Product
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 