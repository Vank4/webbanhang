<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="card p-4 shadow" style="max-width: 700px; margin: 0 auto;">
        <h2 class="text-center mb-4">🛒 Thêm sản phẩm mới</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><i class="fas fa-tag"></i> Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle"></i> Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả chi tiết sản phẩm" required></textarea>
            </div>

            <div class="form-group">
                <label for="price"><i class="fas fa-dollar-sign"></i> Giá (VND)</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá sản phẩm" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="category_id"><i class="fas fa-list-alt"></i> Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image"><i class="fas fa-image"></i> Hình ảnh</label>
                <input type="file" class="form-control-file" id="image" name="image" onchange="previewImage(event)">
                <img id="image-preview" class="mt-3 d-none" style="max-width: 100%; height: auto; border: 1px solid #ccc; border-radius: 8px;" />
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">➕ Thêm sản phẩm</button>
                <a href="/webbanhang/Product" class="btn btn-secondary ml-2">🔙 Quay lại</a>
            </div>
        </form>
    </div>
</div>


<?php include 'app/views/shares/footer.php'; ?>

<!-- Thêm một số style tùy chỉnh -->
<style>
    /* Tạo khung bao quanh form */
    .card {
        border-radius: 16px;
        background-color: #fff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: 600;
        color: #333;
    }

    .form-control,
    .form-control-file,
    .form-select {
        border-radius: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        color: #495057;
        padding: 10px 12px;
        transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
        background-color: #ffffff;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        transform: translateY(-2px);
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0 5px 15px rgba(90, 98, 104, 0.3);
        transform: translateY(-2px);
    }

    #image-preview {
        border-radius: 12px;
        max-height: 250px;
        object-fit: cover;
        border: 1px solid #ccc;
    }

    @media (max-width: 768px) {
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
    .form-select, select.form-control {
    height: 48px;                  /* Chiều cao ô */
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 16px;
    color: #212529 !important;
    background-color: #fff !important;
    border: 1px solid #ced4da;
    border-radius: 10px;
}


</style>

<!-- Thêm script JavaScript để preview hình ảnh -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        var imagePreview = document.getElementById('image-preview');
        var previewContainer = document.getElementById('image-preview-container');

        reader.onload = function() {
            imagePreview.src = reader.result;
            imagePreview.classList.remove('d-none'); // Hiển thị ảnh
            previewContainer.style.display = 'block'; // Hiển thị container ảnh preview
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
