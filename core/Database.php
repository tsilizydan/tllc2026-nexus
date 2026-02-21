<?php
/**
 * Database — TSILIZY Nexus
 *
 * Singleton PDO connection manager.
 * Uses config/database.php for credentials.
 * All queries use prepared statements — no string concatenation.
 */

class Database
{
    private static ?PDO $instance = null;

    /**
     * Get PDO instance (singleton)
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $cfg = require ROOT_PATH . '/config/database.php';

            $dsn = sprintf(
                '%s:host=%s;port=%d;dbname=%s;charset=%s',
                $cfg['driver']   ?? 'mysql',
                $cfg['host']     ?? 'localhost',
                $cfg['port']     ?? 3306,
                $cfg['database'] ?? '',
                $cfg['charset']  ?? 'utf8mb4'
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $cfg['username'] ?? 'root',
                    $cfg['password'] ?? '',
                    $cfg['options']  ?? [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                        PDO::ATTR_PERSISTENT         => false,
                    ]
                );
            } catch (PDOException $e) {
                error_log('[DATABASE] Connection failed: ' . $e->getMessage());
                http_response_code(500);
                if (file_exists(ROOT_PATH . '/app/views/errors/500.php')) {
                    require ROOT_PATH . '/app/views/errors/500.php';
                } else {
                    echo '<h1>Service indisponible</h1>';
                }
                exit;
            }
        }

        return self::$instance;
    }

    /** Prevent cloning */
    private function __clone() {}

    /** Prevent unserialization */
    public function __wakeup()
    {
        throw new \RuntimeException('Cannot unserialize Database singleton.');
    }
}
