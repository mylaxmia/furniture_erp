<?php
/**
 * Supplier Model
 * Handles supplier database operations
 */

class Supplier extends Model
{
    protected $table = 'suppliers';

    /**
     * Get all suppliers with formatted data
     */
    public function getAllFormatted()
    {
        $sql = "SELECT id, supplier_name, company_name, contact_person, phone, email, nip, address, city, postal_code, country, bank_name, bank_account, notes, created_at FROM {$this->table} ORDER BY company_name ASC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new supplier
     */
    public function createSupplier($data)
    {
        return $this->create($data);
    }

    /**
     * Update supplier
     */
    public function updateSupplier($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Get supplier by NIP
     */
    public function findByNip($nip)
    {
        $sql = "SELECT * FROM {$this->table} WHERE nip = ?";
        $stmt = $this->query($sql, [$nip]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if NIP exists (excluding current supplier)
     */
    public function nipExists($nip, $excludeId = null)
    {
        $sql = "SELECT id FROM {$this->table} WHERE nip = ?";
        $params = [$nip];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    /**
     * Get suppliers for dropdown
     */
    public function getForDropdown()
    {
        $sql = "SELECT id, company_name, nip FROM {$this->table} ORDER BY company_name ASC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>