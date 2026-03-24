<?php
/**
 * Expense Controller
 * Handles expense management (CRUD operations)
 */

require_once __DIR__ . '/../models/Expense.php';

class ExpenseController extends Controller
{
    private $expenseModel;
    private $uploadDir = '/public/uploads/expenses/';
    private $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    private $maxFileSize = 5242880; // 5 MB

    public function __construct()
    {
        parent::__construct();
        $this->expenseModel = new Expense();
        
        // Create upload directory if it doesn't exist
        $uploadPath = BASE_PATH . $this->uploadDir;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
    }

    /**
     * Show list of all expenses
     */
    public function index()
    {
        $user = $this->getUserData();
        $expenses = $this->expenseModel->getAll();
        
        // Calculate totals for reporting
        $totals = $this->expenseModel->getTotalWithVAT();

        $this->view('layout/header', ['user' => $user]);
        $this->view('expenses/index', ['user' => $user, 'expenses' => $expenses, 'totals' => $totals]);
        $this->view('layout/footer');
    }

    /**
     * Show create expense form
     */
    public function create()
    {
        $user = $this->getUserData();
        $categories = $this->getExpenseCategories();

        $this->view('layout/header', ['user' => $user]);
        $this->view('expenses/create', ['user' => $user, 'categories' => $categories]);
        $this->view('layout/footer');
    }

    /**
     * Store new expense
     */
    public function store()
    {
        $user = $this->getUserData();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate inputs
            $title = $_POST['title'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $vat_percentage = $_POST['vat_percentage'] ?? 0.23;
            $category = $_POST['category'] ?? '';
            $expense_date = $_POST['expense_date'] ?? date('Y-m-d');
            $notes = $_POST['notes'] ?? '';

            if (empty($title)) {
                $error = t('title_required', 'Title is required');
            } elseif (empty($amount) || !is_numeric($amount)) {
                $error = t('amount_required', 'Valid amount is required');
            } elseif (empty($category)) {
                $error = t('category_required', 'Category is required');
            } else {
                // Handle file upload
                $invoice_path = null;
                if (isset($_FILES['invoice_file']) && $_FILES['invoice_file']['error'] === UPLOAD_ERR_OK) {
                    $uploaded = $this->handleFileUpload($_FILES['invoice_file']);
                    if (is_array($uploaded) && isset($uploaded['error'])) {
                        $error = $uploaded['error'];
                    } else {
                        $invoice_path = $uploaded;
                    }
                }

                if (empty($error)) {
                    $data = [
                        'title' => $title,
                        'amount' => (float) $amount,
                        'vat_percentage' => (float) $vat_percentage,
                        'category' => $category,
                        'expense_date' => $expense_date,
                        'invoice_path' => $invoice_path,
                        'notes' => $notes
                    ];

                    if ($this->expenseModel->createExpense($data)) {
                        header('Location: /furniture_erp/?route=expenses');
                        exit;
                    } else {
                        $error = t('error_saving', 'Error saving expense');
                    }
                }
            }
        }

        $categories = $this->getExpenseCategories();
        $this->view('layout/header', ['user' => $user]);
        $this->view('expenses/create', ['user' => $user, 'categories' => $categories, 'error' => $error]);
        $this->view('layout/footer');
    }

    /**
     * Show edit expense form
     */
    public function edit()
    {
        $user = $this->getUserData();
        $id = $_GET['id'] ?? 0;
        $expense = $this->expenseModel->getById($id);

        if (!$expense) {
            http_response_code(404);
            $this->view('layout/header', ['user' => $user]);
            echo '<div class="container mt-5"><h1>Expense not found</h1></div>';
            $this->view('layout/footer');
            return;
        }

        $categories = $this->getExpenseCategories();
        $this->view('layout/header', ['user' => $user]);
        $this->view('expenses/edit', ['user' => $user, 'expense' => $expense, 'categories' => $categories]);
        $this->view('layout/footer');
    }

    /**
     * Update expense
     */
    public function update()
    {
        $user = $this->getUserData();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $expense = $this->expenseModel->getById($id);

            if (!$expense) {
                $error = t('expense_not_found', 'Expense not found');
            } else {
                $title = $_POST['title'] ?? '';
                $amount = $_POST['amount'] ?? '';
                $vat_percentage = $_POST['vat_percentage'] ?? 0.23;
                $category = $_POST['category'] ?? '';
                $expense_date = $_POST['expense_date'] ?? date('Y-m-d');
                $notes = $_POST['notes'] ?? '';

                if (empty($title) || empty($amount)) {
                    $error = t('fields_required', 'Required fields are missing');
                } else {
                    $invoice_path = $expense['invoice_path'];
                    
                    // Handle new file upload
                    if (isset($_FILES['invoice_file']) && $_FILES['invoice_file']['error'] === UPLOAD_ERR_OK) {
                        $uploaded = $this->handleFileUpload($_FILES['invoice_file']);
                        if (is_array($uploaded) && isset($uploaded['error'])) {
                            $error = $uploaded['error'];
                        } else {
                            $invoice_path = $uploaded;
                        }
                    }

                    if (empty($error)) {
                        $data = [
                            'title' => $title,
                            'amount' => (float) $amount,
                            'vat_percentage' => (float) $vat_percentage,
                            'category' => $category,
                            'expense_date' => $expense_date,
                            'invoice_path' => $invoice_path,
                            'notes' => $notes
                        ];

                        if ($this->expenseModel->update($id, $data)) {
                            header('Location: /furniture_erp/?route=expenses');
                            exit;
                        } else {
                            $error = t('error_updating', 'Error updating expense');
                        }
                    }
                }
            }
        }

        $id = $_POST['id'] ?? 0;
        $expense = $this->expenseModel->getById($id);
        $categories = $this->getExpenseCategories();
        
        $this->view('layout/header', ['user' => $user]);
        $this->view('expenses/edit', ['user' => $user, 'expense' => $expense, 'categories' => $categories, 'error' => $error]);
        $this->view('layout/footer');
    }

    /**
     * Delete expense
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $expense = $this->expenseModel->getById($id);

        if ($expense && $expense['invoice_path']) {
            // Delete file if exists
            $filePath = BASE_PATH . $expense['invoice_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($this->expenseModel->delete($id)) {
            header('Location: /furniture_erp/?route=expenses');
        } else {
            header('Location: /furniture_erp/?route=expenses');
        }
        exit;
    }

    /**
     * Download/view invoice file
     */
    public function getFile()
    {
        $id = $_GET['id'] ?? 0;
        $expense = $this->expenseModel->getById($id);

        if (!$expense || !$expense['invoice_path']) {
            http_response_code(404);
            die('File not found');
        }

        $filePath = BASE_PATH . $expense['invoice_path'];
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            die('File not found');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload($file)
    {
        // Validate file size
        if ($file['size'] > $this->maxFileSize) {
            return ['error' => t('file_too_large', 'File is too large (max 5 MB)')];
        }

        // Validate file extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExtensions)) {
            return ['error' => t('invalid_file_type', 'Invalid file type. Allowed: PDF, JPG, PNG')];
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $ext;
        $uploadDir = BASE_PATH . $this->uploadDir;
        $uploadPath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $this->uploadDir . $filename;
        } else {
            return ['error' => t('upload_failed', 'Failed to upload file')];
        }
    }

    /**
     * Get expense categories
     */
    private function getExpenseCategories()
    {
        return [
            'software' => t('category_software', 'Software'),
            'rent' => t('category_rent', 'Rent'),
            'utilities' => t('category_utilities', 'Utilities'),
            'materials' => t('category_materials', 'Materials'),
            'other' => t('category_other', 'Other')
        ];
    }

    /**
     * Get user data from session
     */
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