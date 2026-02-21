<?php
/**
 * Sitemap Controller — TSILIZY Nexus
 *
 * Generates dynamic XML sitemap for search engine crawlers.
 * Only includes public, indexable pages.
 */

class SitemapController extends Controller
{
    /**
     * Generate and output sitemap.xml
     */
    public function index(): void
    {
        $appUrl = rtrim(config('app.url', 'https://nexus.tsilizy.com'), '/');
        $today  = date('Y-m-d');

        // Public pages with priority and change frequency
        $pages = [
            ['loc' => '/',        'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => '/terms',   'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => '/privacy', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        // Set XML content type
        header('Content-Type: application/xml; charset=utf-8');
        header('X-Robots-Tag: noindex');  // Don't index the sitemap itself

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            echo '  <url>' . "\n";
            echo '    <loc>' . htmlspecialchars($appUrl . $page['loc'], ENT_XML1) . '</loc>' . "\n";
            echo '    <lastmod>' . $today . '</lastmod>' . "\n";
            echo '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            echo '    <priority>' . $page['priority'] . '</priority>' . "\n";
            echo '  </url>' . "\n";
        }

        echo '</urlset>';
        exit;
    }
}
