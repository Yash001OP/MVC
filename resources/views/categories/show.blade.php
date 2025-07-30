<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->category_name }} - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .category-image {
            max-width: 300px;
            max-height: 300px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .info-card {
            border-left: 4px solid #0d6efd;
        }
        .hierarchy-item {
            background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }
        .child-category {
            background: linear-gradient(45deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 4px solid #2196f3;
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
                                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                                    <i class="fas fa-tags me-1"></i>Categories
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $category->category_name }}
                            </li>
                        </ol>
                    </nav>
                    <div class="btn-group" role="group">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                @if($category->category_image)
                                    <img src="{{ asset('storage/' . $category->category_image) }}" 
                                         alt="{{ $category->category_name }}" 
                                         class="category-image mb-3">
                                @else
                                    <div class="category-image mb-3 bg-secondary d-flex align-items-center justify-content-center mx-auto">
                                        <i class="fas fa-image fa-3x text-white"></i>
                                    </div>
                                @endif
                                <h3 class="card-title">{{ $category->category_name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm info-card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Category Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-tag me-2"></i>Name:</strong>
                                        <p class="mb-0">{{ $category->category_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-calendar me-2"></i>Created:</strong>
                                        <p class="mb-0">{{ $category->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-clock me-2"></i>Last Updated:</strong>
                                        <p class="mb-0">{{ $category->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-id me-2"></i>Category ID:</strong>
                                        <p class="mb-0">#{{ $category->id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-sitemap me-2"></i>
                                    Category Hierarchy
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($category->parent)
                                    <div class="mb-3">
                                        <strong><i class="fas fa-level-up-alt me-2"></i>Parent Category:</strong>
                                        <div class="hierarchy-item">
                                            <a href="{{ route('categories.show', $category->parent->id) }}" 
                                               class="text-decoration-none">
                                                {{ $category->parent->category_name }}
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <strong><i class="fas fa-star me-2"></i>Parent Category:</strong>
                                        <div class="hierarchy-item">
                                            <span class="text-success">Main Category (No Parent)</span>
                                        </div>
                                    </div>
                                @endif

                                @if($category->children->count() > 0)
                                    <div>
                                        <strong><i class="fas fa-level-down-alt me-2"></i>Child Categories ({{ $category->children->count() }}):</strong>
                                        @foreach($category->children as $child)
                                            <div class="hierarchy-item child-category">
                                                <a href="{{ route('categories.show', $child->id) }}" 
                                                   class="text-decoration-none">
                                                    {{ $child->category_name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div>
                                        <strong><i class="fas fa-leaf me-2"></i>Child Categories:</strong>
                                        <div class="hierarchy-item">
                                            <span class="text-muted">No child categories</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('categories.edit', $category->id) }}" 
                                       class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Category
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Delete Category
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