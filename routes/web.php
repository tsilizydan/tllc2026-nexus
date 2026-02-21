<?php
/**
 * Routes — TSILIZY Nexus
 *
 * All application route definitions.
 * Each route maps to Controller@method format.
 */

// ===================================================================
// PUBLIC / AUTH ROUTES
// ===================================================================
Router::get('/', 'PageController@home');
Router::get('/terms', 'PageController@terms');
Router::get('/privacy', 'PageController@privacy');
Router::get('/sitemap.xml', 'SitemapController@index');
Router::get('/lang/{locale}', 'LanguageController@switch');
Router::post('/contact', 'ContactFormController@submit');
Router::post('/newsletter/subscribe', 'NewsletterController@subscribe');
Router::get('/login', 'AuthController@loginForm');
Router::post('/login', 'AuthController@login');
Router::get('/register', 'AuthController@registerForm');
Router::post('/register', 'AuthController@register');
Router::get('/logout', 'AuthController@logout');
Router::get('/forgot-password', 'AuthController@forgotPasswordForm');
Router::post('/forgot-password', 'AuthController@forgotPassword');
Router::get('/reset-password/{token}', 'AuthController@resetPasswordForm');
Router::post('/reset-password', 'AuthController@resetPassword');
Router::get('/verify-email/{token}', 'AuthController@verifyEmail');

// ===================================================================
// AUTHENTICATED ROUTES
// ===================================================================
Router::group(['middleware' => ['AuthMiddleware']], function () {

    // Dashboard
    Router::get('/dashboard', 'DashboardController@index');

    // Tasks
    Router::get('/tasks', 'TaskController@index');
    Router::get('/tasks/create', 'TaskController@create');
    Router::post('/tasks/store', 'TaskController@store');
    Router::get('/tasks/{id}', 'TaskController@show');
    Router::get('/tasks/{id}/edit', 'TaskController@edit');
    Router::post('/tasks/{id}/update', 'TaskController@update');
    Router::post('/tasks/{id}/delete', 'TaskController@delete');
    Router::post('/tasks/{id}/status', 'TaskController@updateStatus');
    Router::post('/tasks/reorder', 'TaskController@reorder');

    // Notes
    Router::get('/notes', 'NoteController@index');
    Router::get('/notes/create', 'NoteController@create');
    Router::post('/notes/store', 'NoteController@store');
    Router::get('/notes/{id}', 'NoteController@show');
    Router::get('/notes/{id}/edit', 'NoteController@edit');
    Router::post('/notes/{id}/update', 'NoteController@update');
    Router::post('/notes/{id}/delete', 'NoteController@delete');
    Router::post('/notes/{id}/autosave', 'NoteController@autosave');

    // Agenda
    Router::get('/agenda', 'AgendaController@index');
    Router::get('/agenda/events', 'AgendaController@events');
    Router::post('/agenda/store', 'AgendaController@store');
    Router::post('/agenda/{id}/update', 'AgendaController@update');
    Router::post('/agenda/{id}/delete', 'AgendaController@delete');

    // Projects
    Router::get('/projects', 'ProjectController@index');
    Router::get('/projects/create', 'ProjectController@create');
    Router::post('/projects/store', 'ProjectController@store');
    Router::get('/projects/{id}', 'ProjectController@show');
    Router::get('/projects/{id}/edit', 'ProjectController@edit');
    Router::post('/projects/{id}/update', 'ProjectController@update');
    Router::post('/projects/{id}/delete', 'ProjectController@delete');

    // Contacts
    Router::get('/contacts', 'ContactController@index');
    Router::get('/contacts/export', 'ContactController@export');
    Router::get('/contacts/create', 'ContactController@create');
    Router::post('/contacts/store', 'ContactController@store');
    Router::get('/contacts/{id}', 'ContactController@show');
    Router::get('/contacts/{id}/edit', 'ContactController@edit');
    Router::post('/contacts/{id}/update', 'ContactController@update');
    Router::post('/contacts/{id}/delete', 'ContactController@delete');

    // Websites
    Router::get('/websites', 'WebsiteController@index');
    Router::get('/websites/create', 'WebsiteController@create');
    Router::post('/websites/store', 'WebsiteController@store');
    Router::get('/websites/{id}', 'WebsiteController@show');
    Router::get('/websites/{id}/edit', 'WebsiteController@edit');
    Router::post('/websites/{id}/update', 'WebsiteController@update');
    Router::post('/websites/{id}/delete', 'WebsiteController@delete');

    // Company
    Router::get('/company', 'CompanyController@index');
    Router::post('/company/update', 'CompanyController@update');

    // Notifications
    Router::get('/notifications', 'NotificationController@index');
    Router::get('/notifications/recent', 'NotificationController@recent');
    Router::post('/notifications/{id}/read', 'NotificationController@markRead');
    Router::post('/notifications/read-all', 'NotificationController@markAllRead');
    Router::get('/notifications/unread-count', 'NotificationController@unreadCount');

    // Search
    Router::get('/search', 'SearchController@index');

    // Profile
    Router::get('/profile', 'ProfileController@index');
    Router::post('/profile/update', 'ProfileController@update');
    Router::post('/profile/password', 'ProfileController@updatePassword');
    Router::post('/profile/avatar', 'ProfileController@updateAvatar');

    // Plans & Payments
    Router::get('/plans', 'PlanController@index');
    Router::get('/plans/{id}', 'PlanController@show');
    Router::post('/plans/{id}/select', 'PlanController@select');
    Router::post('/payments/create', 'PaymentController@create');
});

// ===================================================================
// ADMIN ROUTES
// ===================================================================
Router::group(['prefix' => 'admin', 'middleware' => ['AuthMiddleware', 'AdminMiddleware']], function () {
    Router::get('/', 'AdminController@dashboard');
    Router::get('/dashboard', 'AdminController@dashboard');

    // User management
    Router::get('/users', 'AdminController@users');
    Router::get('/users/create', 'AdminController@createUser');
    Router::post('/users/store', 'AdminController@storeUser');
    Router::get('/users/{id}/edit', 'AdminController@editUser');
    Router::post('/users/{id}/update', 'AdminController@updateUser');
    Router::post('/users/{id}/delete', 'AdminController@deleteUser');
    Router::post('/users/{id}/toggle', 'AdminController@toggleUser');

    // Settings
    Router::get('/settings', 'AdminController@settings');
    Router::post('/settings/update', 'AdminController@updateSettings');

    // Payments management
    Router::get('/payments', 'AdminController@payments');
    Router::post('/payments/{id}/validate', 'AdminController@validatePayment');

    // Ads management
    Router::get('/ads', 'AdminController@ads');

    // Contact messages
    Router::get('/messages', 'AdminController@messages');
    Router::post('/messages/{id}/read', 'AdminController@markMessageRead');
    Router::post('/messages/{id}/delete', 'AdminController@deleteMessage');

    // Newsletter
    Router::get('/newsletter', 'AdminController@newsletter');
    Router::post('/newsletter/{id}/delete', 'AdminController@deleteSubscriber');
});

// ===================================================================
// API ROUTES (AJAX — still require auth via controller)
// ===================================================================
Router::group(['prefix' => 'api', 'middleware' => ['AuthMiddleware']], function () {
    Router::post('/tasks/reorder', 'TaskController@reorder');
    Router::get('/notifications/unread', 'NotificationController@unreadCount');
    Router::get('/search', 'SearchController@ajaxSearch');
});
