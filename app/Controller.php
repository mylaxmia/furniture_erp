<?php
/**
 * Base Controller Class
 * All controllers inherit from this
 */

class Controller
{
    /**
     * Base constructor for Controller
     */
    public function __construct()
    {
        // Base controller initialization can go here
    }

    /**
     * Render a view template
     * @param string $view View file path (relative to app/views/)
     * @param array $data Variables to pass to view
     */
    protected function view($view, $data = [])
    {
        extract($data);
        require_once APP_PATH . '/views/' . $view . '.php';
    }

    /**
     * Get POST data
     * @return array
     */
    protected function post()
    {
        return $_POST;
    }

    /**
     * Get GET data
     * @return array
     */
    protected function get()
    {
        return $_GET;
    }

    /**
     * Redirect to URL
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: /$url");
        exit;
    }

    /**
     * JSON Response
     * @param mixed $data
     * @param int $code HTTP status code
     */
    protected function json($data, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
}
?>
