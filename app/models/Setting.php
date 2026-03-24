<?php
/**
 * Setting Model
 * Handles settings in key-value store
 */

require_once __DIR__ . '/../Model.php';

class Setting extends Model
{
    protected $table = 'settings';

    /**
     * Get all settings as key => value array
     */
    public function getAllKeyValue()
    {
        $sql = "SELECT setting_key, setting_value FROM {$this->table}";
        $stmt = $this->query($sql);
        $result = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }

        return $result;
    }

    /**
     * Get a single setting
     */
    public function get($key, $default = null)
    {
        $sql = "SELECT setting_value FROM {$this->table} WHERE setting_key = ? LIMIT 1";
        $stmt = $this->query($sql, [$key]);
        $row = $stmt->fetch();

        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Save or update a setting
     */
    public function set($key, $value)
    {
        // Insert or update (upsert)
        $exists = $this->get($key, null);

        if ($exists !== null) {
            $sql = "UPDATE {$this->table} SET setting_value = ? WHERE setting_key = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$value, $key]);
        }

        return $this->create([
            'setting_key' => $key,
            'setting_value' => $value
        ]);
    }

    /**
     * Delete a setting
     */
    public function deleteByKey($key)
    {
        $sql = "DELETE FROM {$this->table} WHERE setting_key = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$key]);
    }
}
?>