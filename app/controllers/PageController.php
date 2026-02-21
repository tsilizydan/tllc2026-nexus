<?php
/**
 * Page Controller — TSILIZY Nexus
 * 
 * Handles public-facing pages (landing, terms, privacy).
 * Uses SEO helper for full meta tag management.
 */

class PageController extends Controller
{
    /**
     * Landing page
     */
    public function home(): void
    {
        // Authenticated users go straight to dashboard
        // Wrapped in try-catch: if DB is down, landing page still loads for visitors
        try {
            if (Auth::check()) {
                $this->redirect('/dashboard');
                return;
            }
        } catch (\Throwable $e) {
            error_log('[PageController] Auth::check() failed: ' . $e->getMessage());
            // Continue to show landing page even if auth check fails
        }

        // SEO setup
        SEO::page(
            'Plateforme de Productivité Entreprise',
            'Gérez vos tâches, projets, contacts et équipes avec TSILIZY Nexus. Plateforme SaaS de productivité tout-en-un pour les entreprises.',
            '/'
        );

        // Structured data
        SEO::addStructuredData([
            '@context' => 'https://schema.org',
            '@type'    => 'SoftwareApplication',
            'name'     => 'TSILIZY Nexus',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem'     => 'Web',
            'description' => 'Plateforme SaaS de productivité tout-en-un pour les entreprises. Gestion de tâches, projets, contacts, notes et agenda.',
            'url'      => config('app.url', 'https://nexus.tsilizy.com'),
            'offers'   => [
                '@type'         => 'Offer',
                'price'         => '0',
                'priceCurrency' => 'USD',
            ],
            'provider' => [
                '@type' => 'Organization',
                'name'  => 'TSILIZY LLC',
                'url'   => 'https://tsilizy.com',
            ],
        ]);

        // Get plans — graceful fallback if DB fails
        $plans = [];
        try {
            $planModel = new Plan();
            $plans = $planModel->getActive();
        } catch (\Throwable $e) {
            error_log('[PageController] Plan query failed: ' . $e->getMessage());
        }
        
        $this->viewRaw('pages.landing', [
            'pageTitle' => 'Plateforme de Productivité Entreprise',
            'plans'     => $plans,
        ]);
    }

    /**
     * Terms of service
     */
    public function terms(): void
    {
        SEO::page(
            'Conditions d\'utilisation',
            'Consultez les conditions d\'utilisation de la plateforme TSILIZY Nexus. Règles, responsabilités et droits des utilisateurs.',
            '/terms'
        );

        $this->viewRaw('pages.terms', [
            'pageTitle' => 'Conditions d\'utilisation',
        ]);
    }

    /**
     * Privacy policy
     */
    public function privacy(): void
    {
        SEO::page(
            'Politique de confidentialité',
            'Découvrez comment TSILIZY Nexus protège vos données personnelles. Politique de confidentialité conforme au RGPD.',
            '/privacy'
        );

        $this->viewRaw('pages.privacy', [
            'pageTitle' => 'Politique de confidentialité',
        ]);
    }
}
