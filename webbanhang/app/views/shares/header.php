<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Chỉnh nền navbar thành đen và chữ thành trắng */
        .navbar {
            background-color:rgb(234, 255, 97) !important; /* Màu nền đen */
        }

        .navbar-brand, .nav-link {
            color:rgb(0, 0, 0) !important; /* Màu chữ trắng */
        }

        /* Thay đổi màu khi hover vào các liên kết trong navbar */
        .nav-link:hover {
            color:rgb(0, 0, 0) !important; /* Màu chữ sáng khi hover */
        }

        /* Thêm màu nền cho badge */
        .badge-pill {
            background-color: #ff5733; /* Màu nền cam */
            color: #fff; /* Màu chữ trắng */
        }

        /* Thay đổi màu nền khi hover vào badge */
        .badge-pill:hover {
            background-color: #c0392b; /* Màu nền khi hover (đỏ tối) */
        }

        /* Thêm khoảng cách giữa biểu tượng và văn bản trong navbar */
        .nav-link i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="#"><img src="/webbanhang/public/logo.jpg" alt="Mobile World Logo" style="width: 50px; height: 50px; object-fit: contain; margin-right: 10px; border-radius: 50px;">
        Mobile World</a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

            
            <!-- Các mục khác (được đẩy sang phải) -->
            <ul class="navbar-nav ml-auto">
                <!-- Liên kết đến danh sách sản phẩm với biểu tượng -->
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/">
                        <i class="fas fa-list-ul"></i>Danh sách sản phẩm
                    </a>
                </li>
                <!-- Kiểm tra vai trò người dùng trước khi hiển thị "Thêm sản phẩm" -->
                <?php if (SessionHelper::isAdmin()): ?>
                    <!-- Hiển thị liên kết "Thêm sản phẩm" nếu người dùng có role là admin -->
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/add">
                            <i class="fas fa-plus-circle"></i>Thêm sản phẩm
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Thêm giỏ hàng với biểu tượng -->
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/cart">
                        <i class="fas fa-shopping-cart"></i>Giỏ hàng
                        <!-- Hiển thị số lượng sản phẩm trong giỏ hàng nếu có -->
                        <span class="badge badge-pill badge-primary">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>
                        </span>
                    </a>
                </li>

                <!-- Mục thanh toán, yêu cầu đăng nhập -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/checkout">
                            <i class="fas fa-credit-card"></i>Thanh toán
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/account/login">
                            <i class="fas fa-credit-card"></i>Thanh toán
                        </a>
                    </li>
                <?php endif; ?>

        

                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Hiển thị tên người dùng và nút logout khi đã đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/account/logout">
                            <i class="fas fa-sign-out-alt"></i> Logout (<?php echo $_SESSION['username']; ?>)
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Hiển thị nút login và đăng ký khi chưa đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/account/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Thêm script JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
