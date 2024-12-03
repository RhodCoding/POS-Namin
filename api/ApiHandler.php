<?php
require_once __DIR__ . '/../includes/Sanitizer.php';
require_once __DIR__ . '/../classes/Logger.php';
require_once __DIR__ . '/../classes/RateLimiter.php';

class ApiHandler {
    protected $logger;
    protected $rateLimiter;

    public function __construct() {
        $this->logger = Logger::getInstance();
        $this->rateLimiter = RateLimiter::getInstance();
    }

    protected function checkRateLimit() {
        if (!$this->rateLimiter->checkLimit()) {
            $resetTime = $this->rateLimiter->getResetTime();
            $this->sendError('Rate limit exceeded. Please try again in ' . $resetTime . ' seconds.', 429);
        }
    }

    protected function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        
        // Add rate limit headers
        header('X-RateLimit-Remaining: ' . $this->rateLimiter->getRemainingRequests());
        header('X-RateLimit-Reset: ' . $this->rateLimiter->getResetTime());
        
        // Log successful response
        $this->logger->logApiRequest($data);
        
        echo json_encode($data);
        exit();
    }

    protected function sendError($message, $statusCode = 400) {
        // Log error response
        $this->logger->logApiRequest(null, $message);
        
        $this->sendResponse(['error' => $message], $statusCode);
    }

    protected function getRequestData() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->sendError('Invalid JSON data');
        }
        // Sanitize the entire request data array
        return Sanitizer::array($data);
    }

    protected function requireAuth() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->sendError('Unauthorized', 401);
        }
        return $_SESSION['user_id'];
    }

    protected function requireAdmin() {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->sendError('Forbidden', 403);
        }
    }

    protected function validateRequired($data, $fields) {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->sendError("Missing required field: {$field}");
            }
        }
    }

    protected function sanitizeInput($value, $type = 'string') {
        switch ($type) {
            case 'email':
                return Sanitizer::email($value);
            case 'number':
                return Sanitizer::number($value);
            case 'integer':
                return Sanitizer::integer($value);
            case 'url':
                return Sanitizer::url($value);
            case 'filename':
                return Sanitizer::filename($value);
            case 'sql':
                return Sanitizer::sqlIdentifier($value);
            case 'array':
                return Sanitizer::array($value);
            default:
                return Sanitizer::string($value);
        }
    }

    protected function sanitizeQueryParams() {
        $params = [];
        foreach ($_GET as $key => $value) {
            $params[$key] = $this->sanitizeInput($value);
        }
        return $params;
    }
}
