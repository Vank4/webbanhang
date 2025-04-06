<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    // Phương thức lưu tài khoản mới
    function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập fullname!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận không đúng!";
            }

            // Kiểm tra username đã được đăng ký chưa
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            // Nếu có lỗi, trả về trang đăng ký
            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                // Mã hóa mật khẩu
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                
                // Lưu tài khoản mới vào cơ sở dữ liệu
                $result = $this->accountModel->save($username, $fullName, $password);

                if ($result) {
                    // Chuyển hướng người dùng đến trang đăng nhập
                    header('Location: /webbanhang/account/login');
                    exit;
                }
            }
        }
    }

    // Phương thức đăng xuất
    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['full_name']); // Xóa fullname trong session khi đăng xuất
        header('Location: /webbanhang/product');
    }

    // Phương thức kiểm tra đăng nhập
    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $pwd_hashed = $account->password;

                // Kiểm tra mật khẩu
                if (password_verify($password, $pwd_hashed)) {
                    session_start();

                    // Lưu thông tin người dùng vào session
                    $_SESSION['username'] = $account->username;
                    $_SESSION['user_fullname'] = $account->fullname; // Lưu fullname vào session
                    $_SESSION['user_role'] = $account->role;

                    header('Location: /webbanhang/product');
                    exit;
                } else {
                    echo "Mật khẩu không chính xác.";
                }
            } else {
                echo "Không tìm thấy tài khoản.";
            }
        }
    }
}
?>
