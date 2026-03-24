<?php
/**
 * Application Constants
 */

// Company Info
define('APP_NAME', 'Universal Team');
define('COMPANY_NAME', 'Universal Team');
define('CURRENCY', 'PLN');

// VAT Rates (Polish)
define('VAT_STANDARD', 0.23);
define('VAT_REDUCED_8', 0.08);
define('VAT_REDUCED_5', 0.05);

// Paths
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(__FILE__)));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', BASE_PATH . '/app');
}
if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', BASE_PATH . '/public');
}

// Default Language
define('DEFAULT_LANG', 'en');

/**
 * Translation Helper Function
 */
function t($key, $default = '')
{
    global $lang;
    if (!isset($lang)) {
        return $default ?: $key;
    }
    return $lang[$key] ?? ($default ?: $key);
}

/**
 * Get setting value from database by key (cached)
 */
function get_setting($key, $default = null)
{
    static $settings = null;
    global $pdo;

    if ($settings === null) {
        $settings = [];
        if (isset($pdo)) {
            $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
    }

    return $settings[$key] ?? $default;
}

/**
 * Load Language File
 */
$current_lang = $_SESSION['lang'] ?? DEFAULT_LANG;
$lang_file = BASE_PATH . '/lang/' . $current_lang . '.php';

if (file_exists($lang_file)) {
    require_once $lang_file;
} else {
    $lang = [];
}

?>
