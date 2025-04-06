<?php
class SessionHelper
{
    // Kiểm tra người dùng đã đăng nhập hay chưa
    public static function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    // Kiểm tra người dùng hiện tại có phải là admin không
    public static function isAdmin()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    // Nếu chưa đăng nhập thì chuyển hướng về trang login
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header("Location: /webbanhang/account/login");
            exit;
        }
    }

    // Nếu không phải admin thì chặn truy cập và chuyển về trang chủ
    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            header("Location: /webbanhang/");
            exit;
        }
    }
}
