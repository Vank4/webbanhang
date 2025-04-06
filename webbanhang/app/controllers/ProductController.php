<?php
// Load các file cần thiết
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        // Kết nối DB và khởi tạo model sản phẩm
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Trang danh sách sản phẩm (có thể lọc và tìm kiếm)
    public function index()
    {
        $searchTerm = $_GET['search'] ?? '';
        $categoryId = $_GET['category'] ?? '';

        // Nếu có điều kiện lọc hoặc tìm kiếm thì áp dụng
        if ($searchTerm || $categoryId) {
            $products = $this->productModel->searchAndFilterProducts($searchTerm, $categoryId);
        } else {
            $products = $this->productModel->getProducts();
        }

        // Lấy danh mục để hiển thị filter phía trên
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();

        include 'app/views/product/list.php';
    }

    // Alias cho index (nhiều router dùng chung)
    public function list()
    {
        $this->index();
    }

    // Trang chi tiết sản phẩm
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // Hiển thị form thêm sản phẩm (chỉ admin mới truy cập)
    public function add()
    {
        SessionHelper::requireAdmin(); // Kiểm tra quyền admin
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    // Xử lý lưu sản phẩm mới
    public function save()
    {
        SessionHelper::requireAdmin(); // Chặn user thường

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Xử lý ảnh nếu có
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            // Gọi model lưu vào DB
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            // Xử lý lỗi hoặc thành công
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    // Hiển thị form sửa sản phẩm
    public function edit($id)
    {
        SessionHelper::requireAdmin();

        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // Xử lý cập nhật sản phẩm
    public function update()
    {
        SessionHelper::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = $_POST['existing_image'];

            // Nếu có ảnh mới thì cập nhật
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    // Xoá sản phẩm
    public function delete($id)
    {
        SessionHelper::requireAdmin();

        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    // Hàm xử lý upload hình ảnh (kèm validate)
    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);

        if ($check === false) throw new Exception("File không phải là hình ảnh.");
        if ($file["size"] > 10 * 1024 * 1024) throw new Exception("Hình ảnh quá lớn.");
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            throw new Exception("Chỉ cho JPG, JPEG, PNG, GIF.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Tải ảnh thất bại.");
        }

        return $target_file;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }

    // Trang giỏ hàng
    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    // Trang form thanh toán
    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    // Xử lý đặt hàng (tạo order và chi tiết)
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            if (empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();

            try {
                // Tạo đơn hàng
                $stmt = $this->db->prepare("INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu từng sản phẩm vào bảng order_details
                foreach ($_SESSION['cart'] as $product_id => $item) {
                    $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Xoá giỏ hàng, kết thúc giao dịch
                unset($_SESSION['cart']);
                $this->db->commit();

                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    // Trang xác nhận đặt hàng thành công
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
