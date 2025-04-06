<?php

// Kiểm tra nếu giỏ hàng chưa có, khởi tạo giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Thêm sản phẩm vào giỏ hàng (ví dụ: trong controller xử lý thêm sản phẩm vào giỏ)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1,
            'image' => $image
        ];
    }
}

// Xử lý tăng số lượng
if (isset($_POST['action']) && $_POST['action'] == 'increase' && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    }
}

// Xử lý giảm số lượng
if (isset($_POST['action']) && $_POST['action'] == 'decrease' && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id]['quantity'] > 1) {
        $_SESSION['cart'][$id]['quantity']--;
    }
}

// Xử lý xóa sản phẩm
if (isset($_POST['action']) && $_POST['action'] == 'remove' && isset($_POST['id'])) {
    $id = $_POST['id'];
    unset($_SESSION['cart'][$id]);
}

// Tính tổng tiền của mỗi sản phẩm và tổng tiền giỏ hàng
$totalAmount = 0; // Tổng tiền giỏ hàng
?>

<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Giỏ hàng</h1>
    
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="list-group">
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <?php
                // Tính tổng tiền cho mỗi món
                $itemTotal = $item['price'] * $item['quantity'];
                $totalAmount += $itemTotal;
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="/webbanhang/Product/show/<?php echo $id; ?>" class="product-link">
                    <div class="d-flex">
                        <?php if ($item['image']): ?>
                            <img src="/webbanhang/<?php echo $item['image']; ?>" class="img-thumbnail" alt="Product Image" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="ml-3">
                            <h5><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="mb-1">Giá: <?php echo number_format($item['price'], 0, ',', '.'); ?> VND</p>
                            <p class="mb-1">Số lượng: <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="mb-1"><strong>Tổng tiền: </strong><?php echo number_format($itemTotal, 0, ',', '.'); ?> VND</p>
                        </div>
                    </div>
                        </a>
                    
                    <div class="d-flex">
                        <form action="" method="POST" class="form-inline mr-2">
                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary" style="width: 40px;">-</button>
                            <input type="text" class="form-control form-control-sm mx-2" name="quantity" value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 50px;" readonly>
                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary" style="width: 40px;">+</button>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </form>

                        <form action="" method="POST">
                            <button type="submit" name="action" value="remove" class="btn btn-sm btn-danger" style="width: 60px;">Xoá</button>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Hiển thị tổng tiền -->
        <div class="d-flex justify-content-end mt-4">
            <div>
                <h4 class="total-price-label">Tổng tiền giỏ hàng:</h4>
                <h4 class="text-right"><?php echo number_format($totalAmount, 0, ',', '.'); ?> VND</h4>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="/webbanhang/Product" class="btn btn-primary">Tiếp tục mua sắm</a>

        <?php if (isset($_SESSION['username'])): ?>
   
                <a href="/webbanhang/Product/checkout" class="btn btn-success">Thanh Toán</a>

            <?php else: ?>

                <a href="/webbanhang/account/login" class="btn btn-success">Thanh Toán</a>

            <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    /* Thêm màu cho chữ tổng tiền */
    .total-price-label {
        color: #FF5733; /* Màu cam cho chữ "Tổng tiền giỏ hàng" */
    }
    .product-link {
        text-decoration: none !important;        /* Xóa gạch dưới */
        color:rgb(0, 0, 0);              /* Màu xanh Bootstrap */
        font-weight: 600;            /* In đậm nhẹ */
    }

    .product-link:hover {
        text-decoration: underline;  /* Gạch dưới khi hover */
        color:rgb(255, 0, 0);              /* Màu xanh đậm hơn khi hover */
    }
</style>
