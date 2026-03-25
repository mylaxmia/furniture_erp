<?php
/**
 * Product Model
 */

require_once __DIR__ . '/../Model.php';

class Product extends Model
{
    protected $table = 'products';

    public function getAll($limit = 1000, $offset = 0)
    {
        $sql = "SELECT p.*, c.name AS category_name, sc.name AS subcategory_name, s.name AS size_name, co.name AS condition_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN subcategories sc ON p.subcategory_id = sc.id
                LEFT JOIN sizes s ON p.size_id = s.id
                LEFT JOIN conditions co ON p.condition_id = co.id
                ORDER BY p.name ASC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT p.*, c.name AS category_name, sc.name AS subcategory_name, s.name AS size_name, co.name AS condition_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN subcategories sc ON p.subcategory_id = sc.id
                LEFT JOIN sizes s ON p.size_id = s.id
                LEFT JOIN conditions co ON p.condition_id = co.id
                WHERE p.id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($data)
    {
        $columns = [
            'name', 'sku', 'category_id', 'subcategory_id', 'size_id', 'condition_id', 'material', 'color', 'cost_price', 'selling_price', 'vat_percentage', 'stock_quantity', 'location', 'image_path', 'description'
        ];

        $insert = [];
        foreach ($columns as $col) {
            $insert[$col] = $data[$col] ?? null;
        }

        return $this->create($insert);
    }

    public function updateProduct($id, $data)
    {
        $columns = [
            'name', 'sku', 'category_id', 'subcategory_id', 'size_id', 'condition_id', 'material', 'color', 'cost_price', 'selling_price', 'vat_percentage', 'stock_quantity', 'location', 'image_path', 'description'
        ];

        $update = [];
        foreach ($columns as $col) {
            if (array_key_exists($col, $data)) {
                $update[$col] = $data[$col];
            }
        }

        return $this->update($id, $update);
    }

    public function deleteProduct($id)
    {
        $product = $this->getById($id);
        if ($product && !empty($product['image_path'])) {
            $path = BASE_PATH . $product['image_path'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return $this->delete($id);
    }

    public function getCategories()
    {
        $sql = 'SELECT * FROM categories ORDER BY name ASC';
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($categoryId)
    {
        $sql = 'SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC';
        $stmt = $this->query($sql, [$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSubcategories()
    {
        $sql = 'SELECT * FROM subcategories ORDER BY name ASC';
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSizes()
    {
        $sql = 'SELECT * FROM sizes ORDER BY name ASC';
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConditions()
    {
        $sql = 'SELECT * FROM conditions ORDER BY name ASC';
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function skuExists($sku, $excludeId = null)
    {
        $sql = "SELECT id FROM {$this->table} WHERE sku = ?";
        $params = [$sku];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function insertProduct($data)
    {
        $sql = "INSERT INTO {$this->table} (
            name, sku, category_id, subcategory_id, size_id, condition_id,
            material, color, purchase_price, selling_price,
            vat_percentage, discount_percentage,
            stock_quantity, location, description
        ) VALUES (
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?
        )";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['sku'] ?? null,
            $data['category_id'] ?? null,
            $data['subcategory_id'] ?? null,
            $data['size_id'] ?? null,
            $data['condition_id'] ?? null,
            $data['material'] ?? null,
            $data['color'] ?? null,
            $data['purchase_price'] ?? null,
            $data['selling_price'] ?? null,
            $data['vat_percentage'] ?? null,
            $data['discount_percentage'] ?? null,
            $data['stock_quantity'] ?? null,
            $data['location'] ?? null,
            $data['description'] ?? null
        ]);
    }
}
?>