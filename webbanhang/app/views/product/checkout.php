<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thanh toán</h1>

    <form method="POST" action="/webbanhang/Product/processCheckout">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Họ tên -->
                <div class="form-group">
                    <label for="name">Họ tên:</label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="Nhập họ tên của bạn">
                </div>

                <!-- Số điện thoại -->
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required placeholder="Nhập số điện thoại">
                </div>

                <!-- Địa chỉ -->
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" class="form-control" required placeholder="Nhập địa chỉ giao hàng" rows="4"></textarea>
                </div>

                <!-- Nút thanh toán -->
                <button type="submit" class="btn btn-primary btn-block">Thanh toán</button>
            </div>
        </div>
    </form>

    <!-- Quay lại giỏ hàng -->
    <div class="text-center mt-3">
        <a href="/webbanhang/Product/cart" class="btn btn-secondary">Quay lại giỏ hàng</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
<style>
    .container.mt-5 {
    width: 100%; /* Đảm bảo chiều rộng đầy đủ */
    border: 5px solid #ddd; /* Giảm độ rộng của border xuống 5px */
    border-radius: 20px;
    padding: 20px;
    box-sizing: border-box; /* Đảm bảo border và padding không làm thay đổi kích thước tổng thể */
}

}

</style>
