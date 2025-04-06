<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4" style="font-size: 2.2rem; color: #333; font-weight: 600;">Chi tiết sản phẩm</h1>

    <div class="row">
        <!-- Cột hình ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="product-image-container" style="text-align: center;">
                <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" class="img-fluid" style="max-width: 100%; height: auto; object-fit: cover; border-radius: 8px;">
                <?php else: ?>
                    <div style="width: 100%; height: 250px; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center; color: #ccc; text-align: center; border-radius: 8px;">
                        <span>Không có hình ảnh</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cột thông tin sản phẩm -->
        <div class="col-md-6">
            <h3 class="product-name" style="font-size: 1.8rem; color: #333; font-weight: 600; margin-bottom: 15px;"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
            <p style="font-size: 1.2rem;"><strong style="color: #555;">Giá:</strong> <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>

            <h5 class="mt-4" style="font-size: 1.3rem; font-weight: 600;">Mô tả sản phẩm:</h5>
            <p style="font-size: 1.1rem; color: #555; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>

            <!-- Các nút tùy chọn như "Mua ngay" hoặc "Thêm vào giỏ" -->
            <div class="d-flex mt-4">
                <a href="/webbanhang/Product/addTocart/<?php echo $product->id; ?>" class="btn btn-success btn-lg" style="margin-right: 10px; padding: 10px 18px; font-size: 1rem;">Thêm vào giỏ</a>
                <a href="/webbanhang/Product/checkout/<?php echo $product->id; ?>" class="btn btn-primary btn-lg" style="padding: 10px 18px; font-size: 1rem;">Mua ngay</a>
            </div>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="/webbanhang/Product/" class="btn btn-secondary btn-lg">Quay lại danh sách sản phẩm</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    /* Tối ưu giao diện cho màn hình nhỏ */
    .container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .product-image-container {
        margin-bottom: 15px;
    }

    /* Điều chỉnh kích thước tên sản phẩm */
    .product-name {
        font-size: 1.8rem;
        color: #333;
        font-weight: 600;
        margin-bottom: 15px;
    }

    /* Cải thiện bố cục của cột thông tin */
    .col-md-6 {
        padding-left: 20px;
        padding-right: 20px;
    }

    .product-description {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.6;
    }

    .d-flex {
        margin-top: 20px;
    }

    /* Cải thiện nút "Thêm vào giỏ" và "Mua ngay" */
    .btn {
        padding: 10px 18px;
        font-size: 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    /* Hiệu ứng hover cho các nút */
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
    }

    /* Cải thiện nút "Thêm vào giỏ" và "Mua ngay" */
    .btn-success {
        background-color: #28a745;
        color: #fff;
        font-weight: 600;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        font-weight: 600;
    }

    /* Quay lại button */
    .btn-secondary {
        padding: 12px 20px;
        font-size: 1.1rem;
        border-radius: 8px;
        background-color: #6c757d;
        color: #fff;
    }

    /* Tối ưu hóa giao diện hình ảnh */
    .img-fluid {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
