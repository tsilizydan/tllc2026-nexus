<?php
/**
 * Page Controller — TSILIZY Nexus
 * 
 * Handles public-facing pages (landing, terms, privacy).
 */

class PageController extends Controller
{
    /**
     * Landing page
     */
    public function home(): void
    {
        $planModel = new Plan();
        $plans = $planModel->getActive();
        
        $this->viewRaw('pages.landing', [
            'pageTitle' => 'Plateforme de Productivité Entreprise',
            'plans'     => $plans
        ]);
    }

    /**
     * Terms of service
     */
    public function terms(): void
    {
        $this->viewRaw('pages.terms', [
            'pageTitle' => 'Conditions d\'utilisation'
        ]);
    }

    /**
     * Privacy policy
     */
    public function privacy(): void
    {
        $this->viewRaw('pages.privacy', [
            'pageTitle' => 'Politique de confidentialité'
        ]);
    }
}
