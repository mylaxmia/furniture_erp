<?php
/**
 * Supplier Controller
 * Handles supplier management (CRUD operations)
 */

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController extends Controller
{
    private $supplierModel;

    public function __construct()
    {
        parent::__construct();
        $this->supplierModel = new Supplier();
    }

    /**
     * Show list of all suppliers
     */
    public function index()
    {
        $user = $this->getUserData();
        $suppliers = $this->supplierModel->getAllFormatted();

        $this->view('layout/header', ['user' => $user]);
        $this->view('suppliers/index', ['user' => $user, 'suppliers' => $suppliers]);
        $this->view('layout/footer');
    }

    /**
     * Show create supplier form
     */
    public function create()
    {
        $user = $this->getUserData();

        $this->view('layout/header', ['user' => $user]);
        $this->view('suppliers/create', ['user' => $user]);
        $this->view('layout/footer');
    }

    /**
     * Store new supplier
     */
    public function store()
    {
        $user = $this->getUserData();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate inputs
            $supplier_name = trim($_POST['supplier_name'] ?? '');
            $company_name = trim($_POST['company_name'] ?? '');
            $contact_person = trim($_POST['contact_person'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $postal_code = trim($_POST['postal_code'] ?? '');
            $country = trim($_POST['country'] ?? 'Poland');
            $nip = trim($_POST['nip'] ?? '');
            $bank_name = trim($_POST['bank_name'] ?? '');
            $bank_account = trim($_POST['bank_account'] ?? '');
            $notes = trim($_POST['notes'] ?? '');

            if (empty($supplier_name)) {
                $error = t('supplier_name_required', 'Supplier name is required');
            } elseif (empty($company_name)) {
                $error = t('company_name_required', 'Company name is required');
            } elseif (empty($nip)) {
                $error = t('nip_required', 'NIP is required');
            } elseif (!preg_match('/^[0-9]{10}$/', $nip)) {
                $error = t('nip_invalid', 'NIP must be 10 digits');
            } elseif ($this->supplierModel->nipExists($nip)) {
                $error = t('nip_exists', 'NIP already exists');
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = t('email_invalid', 'Invalid email format');
            } else {
                $data = [
                    'supplier_name' => $supplier_name,
                    'company_name' => $company_name,
                    'contact_person' => $contact_person,
                    'phone' => $phone,
                    'email' => $email,
                    'address' => $address,
                    'city' => $city,
                    'postal_code' => $postal_code,
                    'country' => $country,
                    'nip' => $nip,
                    'bank_name' => $bank_name,
                    'bank_account' => $bank_account,
                    'notes' => $notes
                ];

                if ($this->supplierModel->createSupplier($data)) {
                    header('Location: /furniture_erp/?route=suppliers');
                    exit;
                } else {
                    $error = t('error_saving', 'Error saving supplier');
                }
            }
        }

        $this->view('layout/header', ['user' => $user]);
        $this->view('suppliers/create', ['user' => $user, 'error' => $error]);
        $this->view('layout/footer');
    }

    /**
     * Show edit supplier form
     */
    public function edit()
    {
        $user = $this->getUserData();
        $id = $_GET['id'] ?? 0;
        $supplier = $this->supplierModel->getById($id);

        if (!$supplier) {
            http_response_code(404);
            $this->view('layout/header', ['user' => $user]);
            echo '<div class="container mt-5"><h1>Supplier not found</h1></div>';
            $this->view('layout/footer');
            return;
        }

        $this->view('layout/header', ['user' => $user]);
        $this->view('suppliers/edit', ['user' => $user, 'supplier' => $supplier]);
        $this->view('layout/footer');
    }

    /**
     * Update supplier
     */
    public function update()
    {
        $user = $this->getUserData();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $supplier = $this->supplierModel->getById($id);

            if (!$supplier) {
                $error = t('supplier_not_found', 'Supplier not found');
            } else {
                $supplier_name = trim($_POST['supplier_name'] ?? '');
                $company_name = trim($_POST['company_name'] ?? '');
                $contact_person = trim($_POST['contact_person'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $city = trim($_POST['city'] ?? '');
                $postal_code = trim($_POST['postal_code'] ?? '');
                $country = trim($_POST['country'] ?? 'Poland');
                $nip = trim($_POST['nip'] ?? '');
                $bank_name = trim($_POST['bank_name'] ?? '');
                $bank_account = trim($_POST['bank_account'] ?? '');
                $notes = trim($_POST['notes'] ?? '');

                if (empty($supplier_name)) {
                    $error = t('supplier_name_required', 'Supplier name is required');
                } elseif (empty($company_name)) {
                    $error = t('company_name_required', 'Company name is required');
                } elseif (empty($nip)) {
                    $error = t('nip_required', 'NIP is required');
                } elseif (!preg_match('/^[0-9]{10}$/', $nip)) {
                    $error = t('nip_invalid', 'NIP must be 10 digits');
                } elseif ($this->supplierModel->nipExists($nip, $id)) {
                    $error = t('nip_exists', 'NIP already exists');
                } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = t('email_invalid', 'Invalid email format');
                } else {
                    $data = [
                        'supplier_name' => $supplier_name,
                        'company_name' => $company_name,
                        'contact_person' => $contact_person,
                        'phone' => $phone,
                        'email' => $email,
                        'address' => $address,
                        'city' => $city,
                        'postal_code' => $postal_code,
                        'country' => $country,
                        'nip' => $nip,
                        'bank_name' => $bank_name,
                        'bank_account' => $bank_account,
                        'notes' => $notes
                    ];

                    if ($this->supplierModel->updateSupplier($id, $data)) {
                        header('Location: /furniture_erp/?route=suppliers');
                        exit;
                    } else {
                        $error = t('error_updating', 'Error updating supplier');
                    }
                }
            }
        }

        $id = $_POST['id'] ?? 0;
        $supplier = $this->supplierModel->getById($id);

        $this->view('layout/header', ['user' => $user]);
        $this->view('suppliers/edit', ['user' => $user, 'supplier' => $supplier, 'error' => $error]);
        $this->view('layout/footer');
    }

    /**
     * Delete supplier
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if ($this->supplierModel->delete($id)) {
            header('Location: /furniture_erp/?route=suppliers');
        } else {
            header('Location: /furniture_erp/?route=suppliers');
        }
        exit;
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