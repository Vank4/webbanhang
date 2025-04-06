<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    // Khởi tạo kết nối database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy toàn bộ sản phẩm, kèm tên danh mục (JOIN với bảng category)
    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm sản phẩm mới
    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];

        // Kiểm tra đầu vào
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) return $errors;

        // Xử lý thêm vào database
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image)
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        // Gán giá trị vào statement
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật sản phẩm theo ID
    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, description = :description, price = :price, category_id = :category_id, image = :image 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        // Gán giá trị
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xoá sản phẩm theo ID
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Tìm kiếm sản phẩm theo tên
    public function searchProducts($searchTerm)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.name LIKE :searchTerm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Tìm kiếm + Lọc sản phẩm theo tên và danh mục
    public function searchAndFilterProducts($searchTerm, $categoryId)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE 1=1";

        // Điều kiện thêm
        if (!empty($searchTerm)) {
            $query .= " AND p.name LIKE :searchTerm";
        }
        if (!empty($categoryId)) {
            $query .= " AND p.category_id = :categoryId";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($searchTerm)) {
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        }
        if (!empty($categoryId)) {
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
