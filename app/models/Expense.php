<?php
/**
 * Expense Model
 * Handles expense database operations
 */

class Expense extends Model
{
    protected $table = 'expenses';

    /**
     * Get all expenses with pagination
     */
    public function getAll($limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY expense_date DESC";
        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get expense with total (amount + VAT)
     */
    public function getExpenseWithTotal($id)
    {
        $expense = $this->getById($id);
        if ($expense) {
            $vat_amount = $expense['amount'] * $expense['vat_percentage'];
            $expense['vat_amount'] = $vat_amount;
            $expense['total_with_vat'] = $expense['amount'] + $vat_amount;
        }
        return $expense;
    }

    /**
     * Get expenses by category
     */
    public function getByCategory($category)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category = ? ORDER BY expense_date DESC";
        $stmt = $this->query($sql, [$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get expenses within date range
     */
    public function getByDateRange($start_date, $end_date)
    {
        $sql = "SELECT * FROM {$this->table} WHERE expense_date BETWEEN ? AND ? ORDER BY expense_date DESC";
        $stmt = $this->query($sql, [$start_date, $end_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total expenses with VAT for reporting
     */
    public function getTotalWithVAT($start_date = null, $end_date = null)
    {
        $sql = "SELECT 
                    SUM(amount) as total_amount,
                    SUM(amount * vat_percentage) as total_vat,
                    SUM(amount + (amount * vat_percentage)) as total_with_vat
                FROM {$this->table}";

        if ($start_date && $end_date) {
            $sql .= " WHERE expense_date BETWEEN ? AND ?";
            $stmt = $this->query($sql, [$start_date, $end_date]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create expense with file validation
     */
    public function createExpense($data)
    {
        // Validate and prepare data
        if (empty($data['title'])) {
            return false;
        }

        return $this->create([
            'title' => $data['title'],
            'amount' => (float) $data['amount'],
            'vat_percentage' => (float) $data['vat_percentage'],
            'category' => $data['category'],
            'expense_date' => $data['expense_date'],
            'invoice_path' => $data['invoice_path'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
}
?>