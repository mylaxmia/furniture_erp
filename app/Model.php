<?php
/**
 * Base Model Class
 * All models inherit from this
 * Provides database interaction methods
 */

class Model
{
    protected $pdo;
    protected $table = '';

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Get all records
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get record by ID
     * @param int $id
     * @return array
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Insert new record
     * @param array $data
     * @return int Last insert ID
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Update record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $set = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Delete record
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Execute raw query
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    protected function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
?>
