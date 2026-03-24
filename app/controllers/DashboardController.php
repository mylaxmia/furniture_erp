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

    protected function fetchSum(string $table, string $column): float
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT SUM(`$column`) AS total FROM `$table`");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (float) $row['total'] : 0.0;
    }

    protected function getLowStockProducts(): array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT name, quantity FROM products WHERE quantity < 5 ORDER BY quantity ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getDeliveryStatus(): array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM deliveries GROUP BY status");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $status = ['pending' => 0, 'shipped' => 0, 'in_transit' => 0, 'delivered' => 0, 'returned' => 0];
        foreach ($results as $row) {
            $status[$row['status']] = (int) $row['count'];
        }
        return $status;
    }

    protected function getBestSellers(): array
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT p.name, SUM(si.quantity) as total_quantity, SUM(si.line_total) as total_revenue
            FROM sale_items si
            JOIN products p ON si.product_id = p.id
            JOIN sales s ON si.sale_id = s.id
            WHERE s.sale_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
            GROUP BY p.id, p.name
            ORDER BY total_quantity DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getRecentSales(): array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, sale_date, total_amount FROM sales ORDER BY sale_date DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            'total_sales_amount' => $this->fetchSum('sales', 'total_amount'),
            'total_orders' => $this->fetchCount('sales'),
        ];

        $data = [
            'low_stock' => $this->getLowStockProducts(),
            'delivery_status' => $this->getDeliveryStatus(),
            'best_sellers' => $this->getBestSellers(),
            'recent_sales' => $this->getRecentSales(),
        ];

        $this->view('layout/header', ['user' => $user]);
        $this->view('dashboard/index', ['user' => $user, 'stats' => $stats, 'data' => $data]);
        $this->view('layout/footer');
    }
}
?>
