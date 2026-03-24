<?php
/**
 * Auth Controller
 * Handles authentication (login, logout, forgot password, reset password)
 */

require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
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
            header('Location: /furniture_erp/?route=dashboard');
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

                    header('Location: /furniture_erp/?route=dashboard');
                    exit;
                } else {
                    $error = 'Invalid username or password';
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
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

    /**
     * Show forgot password form
     */
    public function forgotPassword()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email format';
            } elseif (!$this->userModel->emailExists($email)) {
                $error = 'No account found with this email';
            } else {
                // For simplicity, generate a reset token and store it
                $resetToken = bin2hex(random_bytes(32));
                // In a real app, you'd send an email with the token
                // For now, just show success message
                $success = 'Password reset link sent to your email (simulated)';
            }
        }

        $this->view('auth/forgot-password', ['error' => $error, 'success' => $success]);
    }

    /**
     * Show reset password form
     */
    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password)) {
                $error = 'Password is required';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match';
            } else {
                // In a real app, verify token and find user
                // For simplicity, assume token is valid and update a dummy user
                $success = 'Password reset successfully';
            }
        }

        $this->view('auth/reset-password', ['error' => $error, 'success' => $success, 'token' => $token]);
    }
}
?>