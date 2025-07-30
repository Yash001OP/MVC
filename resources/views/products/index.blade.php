<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Laravel MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .search-form {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .bulk-actions {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
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
                            <i class="fas fa-box text-primary me-2"></i>
                            Products Management
                        </h1>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-tags me-2"></i>Categories
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="search-form text-white">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">
                                <i class="fas fa-search me-1"></i>Search Products
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Enter product name...">
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">
                                <i class="fas fa-filter me-1"></i>Filter by Category
                            </label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" class="btn btn-light flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bulk-actions" id="bulkActions" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <i class="fas fa-check-square me-1"></i>
                            <span id="selectedCount">0</span> products selected
                        </span>
                        <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                            <i class="fas fa-trash me-1"></i>Delete Selected
                        </button>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th width="120">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input product-checkbox" 
                                                   value="{{ $product->id }}" onchange="updateBulkActions()">
                                        </td>
                                        <td>
                                            @if($product->product_image)
                                                <img src="{{ asset('storage/' . $product->product_image) }}" 
                                                     alt="{{ $product->product_name }}" 
                                                     class="product-image">
                                            @else
                                                <div class="product-image bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $product->product_name }}</strong>
                                            <br>
                                            <small class="text-muted">ID: #{{ $product->id }}</small>
                                        </td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge bg-primary">
                                                    {{ $product->category->category_name }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $product->product_description }}">
                                                {{ Str::limit($product->product_description, 100) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.show', $product->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Products pagination">
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No products found</h4>
                        <p class="text-muted">
                            @if(request('search') || request('category_id'))
                                Try adjusting your search criteria or 
                                <a href="{{ route('products.index') }}">view all products</a>
                            @else
                                Start by creating your first product!
                            @endif
                        </p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <form id="bulkDeleteForm" action="{{ route('products.bulkDelete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="product_ids" id="productIds">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (checkboxes.length > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = checkboxes.length;
            } else {
                bulkActions.style.display = 'none';
            }
        }

        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const productIds = Array.from(checkboxes).map(cb => cb.value);
            
            if (productIds.length === 0) {
                alert('Please select products to delete.');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${productIds.length} product(s)?`)) {
                document.getElementById('productIds').value = JSON.stringify(productIds);
                document.getElementById('bulkDeleteForm').submit();
            }
        }
    </script>
</body>
</html> 