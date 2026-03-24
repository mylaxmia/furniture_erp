<?php
/**
 * Login Controller
 * Handles authentication (login, register, logout)
 */

require_once __DIR__ . '/../models/User.php';

class LoginController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /furniture_erp/');
            exit;
        }

        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Username and password are required';
            } else {
                $user = $this->userModel->login($username, $password);
                
                if ($user) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    
                    header('Location: /furniture_erp/');
                    exit;
                } else {
                    $error = 'Invalid username or password';
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    /**
     * Show register form
     */
    public function register()
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /furniture_erp/');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($username) || empty($email) || empty($password)) {
                $error = 'All fields are required';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } elseif ($this->userModel->usernameExists($username)) {
                $error = 'Username already exists';
            } elseif ($this->userModel->emailExists($email)) {
                $error = 'Email already exists';
            } else {
                // Register successful
                $this->userModel->register($username, $email, $password);
                $success = 'Registration successful! You can now login.';
                
                // Clear form
                $username = '';
                $email = '';
                $password = '';
                $confirm_password = '';
            }
        }

        $this->view('auth/register', [
            'error' => $error,
            'success' => $success,
            'username' => $username ?? '',
            'email' => $email ?? '',
        ]);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session_destroy();
        header('Location: /furniture_erp/?route=login');
        exit;
    }
}
?>
