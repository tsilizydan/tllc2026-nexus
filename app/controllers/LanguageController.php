<?php
class LanguageController extends Controller {
    /**
     * Change the active locale and redirect back
     */
    public function changeLocale(string $locale): void {
        $supported = ['fr', 'en'];
        if (!in_array($locale, $supported)) { $locale = 'fr'; }

        // Store in session and persistent cookie
        $_SESSION['locale'] = $locale;
        setcookie('locale', $locale, time() + 365 * 24 * 60 * 60, '/');

        // Redirect back to the referring page (or home)
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $path = parse_url($referer, PHP_URL_PATH) ?: '/';

        // Strip base path so redirect() doesn't double it
        $base = Router::getBasePath();
        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base));
        }
        if ($path === '' || $path === false) { $path = '/'; }

        $this->redirect($path);
    }
}
