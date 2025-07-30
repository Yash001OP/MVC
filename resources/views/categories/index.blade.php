<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .category-card {
            transition: transform 0.2s;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .category-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .parent-badge {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        }
        /* Custom pagination styling */
        .pagination .page-link {
            border: none;
            color: #6c757d;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #495057;
            transform: translateY(-1px);
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }
        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: transparent;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                        <h1 class="h3 mb-0">
                            <i class="fas fa-tags text-primary me-2"></i>
                            Categories
                        </h1>
                    </div>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Category
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($categories->count() > 0)
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card category-card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">
                                            @if($category->category_image)
                                                <img src="{{ asset('storage/' . $category->category_image) }}" 
                                                     alt="{{ $category->category_name }}" 
                                                     class="category-image me-3">
                                            @else
                                                <div class="category-image me-3 bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-1">{{ $category->category_name }}</h5>
                                                @if($category->parent)
                                                    <span class="badge parent-badge text-white">
                                                        <i class="fas fa-level-up-alt me-1"></i>
                                                        {{ $category->parent->category_name }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-star me-1"></i>Main Category
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $category->created_at->diffForHumans() }}
                                            </small>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('categories.show', $category->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('categories.edit', $category->id) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($categories->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Categories pagination">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No categories found</h4>
                        <p class="text-muted">Start by creating your first category!</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 