<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 text-center">
            <img src="/webbanhang/uploads/banner-quang-cao-du-khach-hang-hieu-qua-3.jpg" class="img-fluid rounded" alt="Banner">
        </div>
    </div>
</div>



<div class="container mt-5 mb-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    <?php if (SessionHelper::isAdmin()): ?>
    <a href="/webbanhang/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <?php endif; ?>

    <!-- Chức năng tìm kiếm -->
<!-- Form tìm kiếm sản phẩm -->
<form method="GET" action="/webbanhang/Product" class="form-inline justify-content-center mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm sản phẩm" 
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
            style="border-radius: 12px; width: 300px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <!-- Bộ lọc danh mục -->
    <form method="GET" action="/webbanhang/Product" class="form-inline justify-content-center mb-4">
        <?php
        if (!isset($categories)) {
            $categoryModel = new CategoryModel((new Database())->getConnection());
            $categories = $categoryModel->getCategories();
        }
        ?>
        <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <label for="category" class="mr-2 font-weight-bold">Lọc theo danh mục:</label>
        <select name="category" id="category" class="form-control mr-2" style="width: 250px; border-radius: 12px;">
            <option value="">-- Tất cả --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" 
                    <?php if (isset($_GET['category']) && $_GET['category'] == $category->id) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-outline-success">Lọc</button>
    </form>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach ($products as $product): ?>
        <div class="col">
            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-light rounded product-card">
                    <!-- Hình ảnh sản phẩm với kích thước cố định -->
                    <div class="card-img-container" style="width: 100%; height: 200px; overflow: hidden;">
                        <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100%; background-color: #f0f0f0; color: #ccc; text-align: center;">
                            <span>Không có hình ảnh</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </h5>
                        <p><strong>Giá:</strong> <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                        <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="d-flex justify-content-between">
                            <?php if (SessionHelper::isAdmin()): ?>
                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            <?php endif; ?>
                            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"class="btn btn-primary btn-sm">Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    .col-12 img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        margin-bottom: 10px;
    }
    /* Hiệu ứng phóng to khi di chuột vào card sản phẩm */
    .product-card {
        transition: transform 0.3s ease;
    }
    .product-card:hover {
        transform: scale(1.05);
    }
</style>