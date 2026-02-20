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
    'database'  => 'tsilscpx_tsilizy_nexus',
    'username'  => 'tsilscpx_chibi_admin',
    'password'  => '9@UPN~I@O]Dw',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
    ],
];
