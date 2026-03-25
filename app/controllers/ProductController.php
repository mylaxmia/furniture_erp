<?php
/**
 * Product Controller
 */

require_once __DIR__ . '/../models/Product.php';

class ProductController extends Controller
{
    private $productModel;
    private $uploadDir = '/public/uploads/products/';
    private $allowedImageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $maxImageSize = 5242880; // 5MB

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();

        $path = BASE_PATH . $this->uploadDir;
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function index()
    {
        $user = $this->getUserData();
        $products = $this->productModel->getAll();

        $this->view('layout/header', ['user' => $user]);
        $this->view('products/index', ['user' => $user, 'products' => $products]);
        $this->view('layout/footer');
    }

    public function create()
    {
        $user = $this->getUserData();
        $data = [
            'categories' => $this->productModel->getCategories(),
            'subcategories' => $this->productModel->getAllSubcategories(),
            'sizes' => $this->productModel->getSizes(),
            'conditions' => $this->productModel->getConditions(),
        ];

        $this->view('layout/header', ['user' => $user]);
        $this->view('products/create', array_merge(['user' => $user], $data));
        $this->view('layout/footer');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect POST data
            $data = $_POST;

            // Validate required fields
            if (empty($data['name']) || empty($data['selling_price']) || !isset($data['stock_quantity'])) {
                // Handle validation error - for now, just redirect back
                header('Location: /furniture_erp/?route=products/create');
                exit;
            }

            // Call model function to insert product
            $this->productModel->createProduct($data);

            // Redirect to product list after success
            header('Location: /furniture_erp/?route=products');
            exit;
        }
    }

    public function edit()
    {
        $user = $this->getUserData();
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            $this->view('layout/header', ['user' => $user]);
            echo '<div class="container mt-5"><h1>Product not found</h1></div>';
            $this->view('layout/footer');
            return;
        }

        $subcategories = $this->productModel->getAllSubcategories();
        $currentCategorySubcategories = $product['category_id'] ? $this->productModel->getSubcategories($product['category_id']) : [];

        $data = [
            'categories' => $this->productModel->getCategories(),
            'subcategories' => $subcategories,
            'currentSubcategories' => $currentCategorySubcategories,
            'sizes' => $this->productModel->getSizes(),
            'conditions' => $this->productModel->getConditions(),
            'product' => $product,
        ];

        $this->view('layout/header', ['user' => $user]);
        $this->view('products/edit', array_merge(['user' => $user], $data));
        $this->view('layout/footer');
    }

    public function update()
    {
        $user = $this->getUserData();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $product = $this->productModel->getById($id);

            if (!$product) {
                $error = t('product_not_found', 'Product not found');
            } else {
                $name = trim($_POST['name'] ?? '');
                $sku = trim($_POST['sku'] ?? '');
                $category_id = $_POST['category_id'] ?? null;
                $subcategory_id = $_POST['subcategory_id'] ?? null;
                $size_id = $_POST['size_id'] ?? null;
                $condition_id = $_POST['condition_id'] ?? null;
                $material = trim($_POST['material'] ?? '');
                $color = trim($_POST['color'] ?? '');
                $cost_price = $_POST['cost_price'] ?? null;
                $selling_price = $_POST['selling_price'] ?? null;
                $vat_percentage = $_POST['vat_percentage'] ?? 23;
                $stock_quantity = $_POST['stock_quantity'] ?? 0;
                $location = trim($_POST['location'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if (empty($name) || empty($sku) || empty($category_id)) {
                    $error = t('fields_required', 'Required fields are missing');
                } elseif ($this->productModel->skuExists($sku, $id)) {
                    $error = t('sku_exists', 'SKU already exists');
                } elseif (!is_numeric($cost_price) || !is_numeric($selling_price)) {
                    $error = t('price_invalid', 'Cost and selling price must be numeric');
                } elseif ($stock_quantity < 0 || !is_numeric($stock_quantity)) {
                    $error = t('stock_invalid', 'Stock must be 0 or greater');
                } else {
                    $image_path = $product['image_path'];

                    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
                        $upload = $this->handleImageUpload($_FILES['image_path']);
                        if (is_array($upload) && isset($upload['error'])) {
                            $error = $upload['error'];
                        } else {
                            if (!empty($product['image_path'])) {
                                $oldPath = BASE_PATH . $product['image_path'];
                                if (file_exists($oldPath)) {
                                    unlink($oldPath);
                                }
                            }
                            $image_path = $upload;
                        }
                    }

                    if (empty($error)) {
                        $data = [
                            'name' => $name,
                            'sku' => $sku,
                            'category_id' => $category_id,
                            'subcategory_id' => $subcategory_id ?: null,
                            'size_id' => $size_id ?: null,
                            'condition_id' => $condition_id ?: null,
                            'material' => $material,
                            'color' => $color,
                            'cost_price' => (float)$cost_price,
                            'selling_price' => (float)$selling_price,
                            'vat_percentage' => (float)$vat_percentage,
                            'stock_quantity' => (int)$stock_quantity,
                            'location' => $location,
                            'image_path' => $image_path,
                            'description' => $description,
                        ];

                        if ($this->productModel->updateProduct($id, $data)) {
                            header('Location: /furniture_erp/?route=products');
                            exit;
                        }
                        $error = t('error_updating', 'Error updating product');
                    }
                }
            }
        }

        $product = $this->productModel->getById($id);
        $subcategories = $product['category_id'] ? $this->productModel->getSubcategories($product['category_id']) : [];

        $data = [
            'categories' => $this->productModel->getCategories(),
            'subcategories' => $subcategories,
            'sizes' => $this->productModel->getSizes(),
            'conditions' => $this->productModel->getConditions(),
            'product' => $product,
            'error' => $error,
        ];

        $this->view('layout/header', ['user' => $user]);
        $this->view('products/edit', array_merge(['user' => $user], $data));
        $this->view('layout/footer');
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->productModel->deleteProduct($id);
        header('Location: /furniture_erp/?route=products');
        exit;
    }

    private function handleImageUpload($file)
    {
        if ($file['size'] > $this->maxImageSize) {
            return ['error' => t('file_too_large', 'File too large')];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedImageExt)) {
            return ['error' => t('invalid_file_type', 'Invalid file type')];
        }

        $filename = uniqid('product_') . '.' . $ext;
        $dst = BASE_PATH . $this->uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dst)) {
            return ['error' => t('upload_failed', 'Failed to upload file')];
        }

        return '/furniture_erp' . $this->uploadDir . $filename;
    }

    private function getUserData()
    {
        return [
            'username' => $_SESSION['username'] ?? 'User',
            'email' => $_SESSION['email'] ?? '',
            'role' => $_SESSION['role'] ?? 'user'
        ];
    }
}
?>