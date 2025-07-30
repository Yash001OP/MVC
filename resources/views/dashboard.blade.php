<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel MVC Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .stats-card {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
        }
        .category-card {
            background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
        }
        .product-card {
            background: linear-gradient(45deg, #43e97b 0%, #38f9d7 100%);
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-cogs me-3"></i>
                        Laravel MVC Management System
                    </h1>
                    <p class="lead mb-4">
                        Complete CRUD system for Categories and Products with PostgreSQL, 
                        featuring image uploads, search, filtering, and bulk operations.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('categories.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-tags me-2"></i>Manage Categories
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-box me-2"></i>Manage Products
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-database fa-6x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="h3 mb-4">System Features</h2>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-database fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">PostgreSQL Database</h5>
                        <p class="card-text">Robust database with proper relationships and constraints</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-upload fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Image Upload</h5>
                        <p class="card-text">Secure file upload with validation and storage management</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-search fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Search & Filter</h5>
                        <p class="card-text">Advanced search and filtering capabilities</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Bulk Operations</h5>
                        <p class="card-text">Efficient bulk delete and management operations</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card feature-card category-card h-100">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-tags fa-2x me-3"></i>
                            <h4 class="mb-0">Category Management</h4>
                        </div>
                        <p class="mb-4">Manage hierarchical categories with parent-child relationships, image uploads, and full CRUD operations.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-right me-2"></i>Manage Categories
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card feature-card product-card h-100">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-box fa-2x me-3"></i>
                            <h4 class="mb-0">Product Management</h4>
                        </div>
                        <p class="mb-4">Complete product management with category relationships, search, filtering, and bulk operations.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-right me-2"></i>Manage Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 