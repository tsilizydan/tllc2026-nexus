<?php
/**
 * Database Configuration — TSILIZY Nexus
 * 
 * PDO MySQL connection with secure defaults.
 * Update credentials for your environment.
 */

return [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'database'  => 'tsilizy_nexus',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
    ],
];
