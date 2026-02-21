<?php
class LanguageController extends Controller {
    /**
     * Switch language and redirect back
     */
    public function switch(string $locale): void {
        $supported = ['fr', 'en'];
        if (!in_array($locale, $supported)) { $locale = 'fr'; }
        $_SESSION['locale'] = $locale;
        setcookie('locale', $locale, time() + 365 * 24 * 60 * 60, '/');
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect(parse_url($referer, PHP_URL_PATH) ?: '/');
    }
}
