<?php
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../models/User.php';

class SettingsController extends Controller
{
    private $settingModel;
    private $userModel;
    private $uploadDir = '/public/uploads/logo/';
    private $allowedLogoExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    private $maxLogoSize = 5242880; // 5 MB

    public function __construct()
    {
        parent::__construct();
        $this->settingModel = new Setting();
        $this->userModel = new User();

        $uploadPath = BASE_PATH . $this->uploadDir;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
    }

    public function index()
    {
        // Default redirects to profile settings
        header('Location: /furniture_erp/?route=settings/profile');
        exit;
    }

    private function render($section, $data = [])
    {
        $data['settings'] = $this->settingModel->getAllKeyValue();
        $data['activeTab'] = $section;
        $data['user'] = $this->getUserData();

        $this->view('layout/header', ['user' => $data['user']]);
        $this->view('settings/' . $section, $data);
        $this->view('layout/footer');
    }

    private function saveSettings(array $values)
    {
        foreach ($values as $key => $value) {
            $this->settingModel->set($key, trim($value));
        }
        // Clear cached helper value from constants
        if (function_exists('get_setting')) {
            // Re-initialize by clearing static through hack (no direct access) via reload in next request.
        }
        return true;
    }

    public function profile()
    {
        $error = '';
        $success = '';
        $currentUserId = $_SESSION['user_id'] ?? null;
        $userData = $this->userModel->getById($currentUserId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($email)) {
                $error = t('fields_required', 'Required fields are missing');
            } elseif ($existing = $this->userModel->findByUsername($username)) {
                if ($existing['id'] != $currentUserId) {
                    $error = t('username_exists', 'Username already exists');
                }
            } elseif ($existingEmail = $this->userModel->findByEmail($email)) {
                if ($existingEmail['id'] != $currentUserId) {
                    $error = t('email_exists', 'Email already exists');
                }
            }

            if (!$error) {
                $updateData = ['username' => $username, 'email' => $email];

                if (!empty($password)) {
                    if (strlen($password) < 6) {
                        $error = t('password_minimum', 'Password must be at least 6 characters');
                    } else {
                        $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
                    }
                }

                if (!$error && $this->userModel->update($currentUserId, $updateData)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $success = t('profile_updated', 'Profile updated successfully');
                    $userData = $this->userModel->getById($currentUserId);
                } elseif (!$error) {
                    $error = t('error_updating', 'Error updating profile');
                }
            }
        }

        $this->render('profile', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'userData' => $userData,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function company()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'company_name' => $_POST['company_name'] ?? '',
                'address' => $_POST['address'] ?? '',
                'city' => $_POST['city'] ?? '',
                'postal_code' => $_POST['postal_code'] ?? '',
                'country' => $_POST['country'] ?? 'Poland',
                'nip' => $_POST['nip'] ?? '',
                'regon' => $_POST['regon'] ?? '',
                'bank_account' => $_POST['bank_account'] ?? '',
                'iban' => $_POST['iban'] ?? '',
                'swift_bic' => $_POST['swift_bic'] ?? ''
            ];

            // Basic required validation
            if (empty($data['company_name']) || empty($data['address']) || empty($data['city']) || empty($data['postal_code'])) {
                $error = t('fields_required', 'Required fields are missing');
            } else {
                // Handle logo file upload when present
                if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
                    $logo = $_FILES['company_logo'];
                    $logoresult = $this->handleLogoUpload($logo);

                    if (is_array($logoresult) && isset($logoresult['error'])) {
                        $error = $logoresult['error'];
                    } else {
                        $data['company_logo'] = $logoresult;
                    }
                }

                if (!$error) {
                    $this->saveSettings($data);
                    $success = t('company_updated', 'Company settings updated successfully');
                }
            }
        }

        $this->render('company', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    public function email()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'sender_name' => $_POST['sender_name'] ?? '',
                'sender_email' => $_POST['sender_email'] ?? '',
                'smtp_host' => $_POST['smtp_host'] ?? '',
                'smtp_port' => $_POST['smtp_port'] ?? '',
                'smtp_username' => $_POST['smtp_username'] ?? '',
                'smtp_password' => $_POST['smtp_password'] ?? '',
                'smtp_encryption' => $_POST['smtp_encryption'] ?? 'tls'
            ];

            if (empty($data['sender_name']) || empty($data['sender_email']) || empty($data['smtp_host'])) {
                $error = t('fields_required', 'Required fields are missing');
            } else {
                $this->saveSettings($data);
                $success = t('email_updated', 'SMTP settings saved successfully');
            }
        }

        $this->render('email', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    public function accountant()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'accountant_name' => $_POST['accountant_name'] ?? '',
                'accountant_email' => $_POST['accountant_email'] ?? '',
                'accountant_phone' => $_POST['accountant_phone'] ?? ''
            ];

            if (empty($data['accountant_name']) || empty($data['accountant_email'])) {
                $error = t('fields_required', 'Required fields are missing');
            } else {
                $this->saveSettings($data);
                $success = t('accountant_updated', 'Accountant settings updated successfully');
            }
        }

        $this->render('accountant', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    public function financial()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'default_currency' => $_POST['default_currency'] ?? 'PLN',
                'currency_symbol' => $_POST['currency_symbol'] ?? 'zł',
                'default_vat' => $_POST['default_vat'] ?? '23'
            ];

            if (empty($data['default_currency']) || empty($data['currency_symbol'])) {
                $error = t('fields_required', 'Required fields are missing');
            } else {
                $this->saveSettings($data);
                $success = t('financial_updated', 'Financial settings saved successfully');
            }
        }

        $this->render('financial', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    public function language()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'default_language' => $_POST['default_language'] ?? 'en',
                'allow_switch' => isset($_POST['allow_switch']) && $_POST['allow_switch'] === '1' ? '1' : '0'
            ];

            $this->saveSettings($data);
            $success = t('language_updated', 'Language settings updated successfully');
        }

        $this->render('language', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    public function invoice()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'invoice_prefix' => $_POST['invoice_prefix'] ?? 'FV/',
                'next_invoice_number' => $_POST['next_invoice_number'] ?? '1',
                'invoice_footer_note' => $_POST['invoice_footer_note'] ?? ''
            ];

            if (empty($data['invoice_prefix']) || empty($data['next_invoice_number'])) {
                $error = t('fields_required', 'Required fields are missing');
            } else {
                $this->saveSettings($data);
                $success = t('invoice_updated', 'Invoice settings saved successfully');
            }
        }

        $this->render('invoice', [
            'settings' => $this->settingModel->getAllKeyValue(),
            'error' => $error,
            'success' => $success
        ]);
    }

    private function handleLogoUpload($file)
    {
        if ($file['size'] > $this->maxLogoSize) {
            return ['error' => t('file_too_large', 'File too large')];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedLogoExtensions)) {
            return ['error' => t('invalid_file_type', 'Invalid file type')];
        }

        $filename = uniqid('logo_') . '.' . $ext;
        $uploadPath = BASE_PATH . $this->uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return '/furniture_erp' . $this->uploadDir . $filename;
        }

        return ['error' => t('upload_failed', 'Failed to upload file')];
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