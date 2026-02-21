<?php
/**
 * Application Configuration — TSILIZY Nexus
 *
 * Central configuration for the application.
 * Sensitive values (DB creds) stay in config/database.php.
 */

return [
    // ---------------------------------------------------------------
    // General
    // ---------------------------------------------------------------
    'name'     => 'TSILIZY Nexus',
    'url'      => 'https://nexus.tsilizy.com',   // Set to your production URL, e.g. https://nexus.tsilizy.com
    'locale'   => 'fr',
    'timezone' => 'Africa/Douala',
    'debug'    => false,   // NEVER true in production

    // ---------------------------------------------------------------
    // Security
    // ---------------------------------------------------------------
    'encryption_key'    => 'CHANGE_ME_TO_RANDOM_64_CHAR_STRING_abcdef1234567890abcdef1234567890',
    'encryption_method' => 'AES-256-CBC',
    'csrf_token_name'   => '_csrf_token',

    // ---------------------------------------------------------------
    // Session
    // ---------------------------------------------------------------
    'remember_lifetime' => 2592000,   // 30 days in seconds

    // ---------------------------------------------------------------
    // Rate limiting
    // ---------------------------------------------------------------
    'rate_limit_attempts' => 5,
    'rate_limit_window'   => 900,     // 15 minutes in seconds

    // ---------------------------------------------------------------
    // File uploads
    // ---------------------------------------------------------------
    'upload_max_size'   => 5242880,   // 5 MB
    'upload_allowed'    => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'],
    'upload_path'       => ROOT_PATH . '/storage/uploads',

    // ---------------------------------------------------------------
    // Feature toggles
    // ---------------------------------------------------------------
    'features' => [
        'tasks'         => true,
        'notes'         => true,
        'agenda'        => true,
        'projects'      => true,
        'contacts'      => true,
        'websites'      => true,
        'company'       => true,
        'notifications' => true,
        'search'        => true,
        'plans'         => true,
        'payments'      => false,   // Enable when payment gateway is configured
        'ads'           => true,
    ],
];
