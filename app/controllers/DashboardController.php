<?php
/**
 * Dashboard Controller
 * Shows main dashboard/overview
 */

class DashboardController extends Controller
{
    protected function fetchCount(string $table): int
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `$table`");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['total'] : 0;
    }

    public function index()
    {
        // Get user from session
        $user = [
            'username' => $_SESSION['username'] ?? 'User',
            'email' => $_SESSION['email'] ?? '',
            'role' => $_SESSION['role'] ?? 'user'
        ];

        $stats = [
            'total_products' => $this->fetchCount('products'),
            'total_suppliers' => $this->fetchCount('suppliers'),
            'total_sales' => $this->fetchCount('sales'),
        ];

        $this->view('layout/header', ['user' => $user]);
        $this->view('dashboard/index', ['user' => $user, 'stats' => $stats]);
        $this->view('layout/footer');
    }
}
?>
