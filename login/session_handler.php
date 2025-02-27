<?php
require_once '../conn.php'; // Your PDO connection file

class DatabaseSessionHandler implements SessionHandlerInterface {
    private $pdo;
    private $ttl = 90 * 24 * 60 * 60; // 90 days in seconds

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function open($savePath, $sessionName): bool {
        return true; // PDO connection is already open
    }

    public function close(): bool {
        return true;
    }

    public function read($id): string|false {
        $stmt = $this->pdo->prepare("SELECT refresh_token FROM sessions WHERE id = :id AND expires_at > NOW()");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetchColumn();
        return $data !== false ? $data : '';
    }

    public function write($id, $data): bool {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) return false;

        $refresh_token = bin2hex(random_bytes(32)); // Generate secure refresh token
        $expires_at = date('Y-m-d H:i:s', time() + $this->ttl);

        $stmt = $this->pdo->prepare("
            INSERT INTO sessions (id, user_id, refresh_token, expires_at)
            VALUES (:id, :user_id, :refresh_token, :expires_at)
            ON DUPLICATE KEY UPDATE 
                refresh_token = :refresh_token, 
                expires_at = :expires_at
        ");
        return $stmt->execute([
            'id' => $id,
            'user_id' => $user_id,
            'refresh_token' => $refresh_token,
            'expires_at' => $expires_at
        ]);
    }

    public function destroy($id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function gc($maxLifetime): int|false {
        $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE expires_at < NOW()");
        $stmt->execute();
        return $stmt->rowCount();
    }
}

// Configure session settings
ini_set('session.gc_maxlifetime', 90 * 24 * 60 * 60); // 90 days
ini_set('session.cookie_lifetime', 90 * 24 * 60 * 60); // 90 days
session_set_cookie_params([
    'lifetime' => 90 * 24 * 60 * 60, // 90 days
    'path' => '/',
    'domain' => '', // Set to your domain for production
    'secure' => true, // Only over HTTPS
    'httponly' => true, // Prevent JavaScript access
    'samesite' => 'Strict' // Prevent CSRF
]);

// Start session with custom handler
$handler = new DatabaseSessionHandler($pdo);
session_set_save_handler($handler, true);
session_start();