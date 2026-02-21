<?php
/**
 * SEO Helper — TSILIZY Nexus
 *
 * Static helper for managing meta tags, Open Graph, Twitter Cards,
 * canonical URLs, structured data, and robots directives.
 */

class SEO
{
    private static string $title = '';
    private static string $description = '';
    private static string $keywords = '';
    private static string $canonical = '';
    private static string $robots = 'index, follow';
    private static array  $og = [];
    private static array  $twitter = [];
    private static array  $structuredData = [];

    // -----------------------------------------------------------------
    // Setters
    // -----------------------------------------------------------------

    public static function setTitle(string $title): void
    {
        self::$title = $title;
    }

    public static function setDescription(string $description): void
    {
        self::$description = $description;
    }

    public static function setKeywords(string $keywords): void
    {
        self::$keywords = $keywords;
    }

    public static function setCanonical(string $url): void
    {
        self::$canonical = $url;
    }

    public static function setRobots(string $robots): void
    {
        self::$robots = $robots;
    }

    public static function setOpenGraph(array $data): void
    {
        self::$og = array_merge(self::$og, $data);
    }

    public static function setTwitterCard(array $data): void
    {
        self::$twitter = array_merge(self::$twitter, $data);
    }

    public static function addStructuredData(array $data): void
    {
        self::$structuredData[] = $data;
    }

    // -----------------------------------------------------------------
    // Convenience: set all defaults for a public page
    // -----------------------------------------------------------------

    public static function page(string $title, string $description, string $path = ''): void
    {
        $appUrl = rtrim(config('app.url', ''), '/');
        $fullTitle = $title . ' — ' . config('app.name', 'TSILIZY Nexus');

        self::setTitle($fullTitle);
        self::setDescription($description);
        self::setKeywords('productivité, gestion, SaaS, tâches, projets, TSILIZY, équipe, organisation');
        self::setCanonical($appUrl . '/' . ltrim($path, '/'));

        self::setOpenGraph([
            'title'       => $fullTitle,
            'description' => $description,
            'url'         => $appUrl . '/' . ltrim($path, '/'),
            'type'        => 'website',
            'site_name'   => config('app.name', 'TSILIZY Nexus'),
            'locale'      => 'fr_FR',
            'image'       => $appUrl . '/public/assets/img/og-preview.png',
        ]);

        self::setTwitterCard([
            'card'        => 'summary_large_image',
            'title'       => $fullTitle,
            'description' => $description,
            'image'       => $appUrl . '/public/assets/img/og-preview.png',
        ]);
    }

    /**
     * Mark page as private (noindex, nofollow)
     */
    public static function noIndex(): void
    {
        self::setRobots('noindex, nofollow');
    }

    // -----------------------------------------------------------------
    // Render
    // -----------------------------------------------------------------

    /**
     * Render all meta tags as HTML string
     */
    public static function render(): string
    {
        $html = '';

        // Title
        if (self::$title) {
            $html .= '    <title>' . e(self::$title) . '</title>' . "\n";
        }

        // Description
        if (self::$description) {
            $html .= '    <meta name="description" content="' . e(self::$description) . '">' . "\n";
        }

        // Keywords
        if (self::$keywords) {
            $html .= '    <meta name="keywords" content="' . e(self::$keywords) . '">' . "\n";
        }

        // Author
        $html .= '    <meta name="author" content="TSILIZY LLC">' . "\n";

        // Robots
        $html .= '    <meta name="robots" content="' . e(self::$robots) . '">' . "\n";

        // Canonical
        if (self::$canonical) {
            $html .= '    <link rel="canonical" href="' . e(self::$canonical) . '">' . "\n";
        }

        // Open Graph
        foreach (self::$og as $property => $content) {
            if ($content) {
                $html .= '    <meta property="og:' . e($property) . '" content="' . e($content) . '">' . "\n";
            }
        }

        // Twitter Card
        foreach (self::$twitter as $name => $content) {
            if ($content) {
                $html .= '    <meta name="twitter:' . e($name) . '" content="' . e($content) . '">' . "\n";
            }
        }

        return $html;
    }

    /**
     * Render JSON-LD structured data scripts
     */
    public static function renderStructuredData(): string
    {
        if (empty(self::$structuredData)) return '';

        $html = '';
        foreach (self::$structuredData as $data) {
            $html .= '    <script type="application/ld+json">' . "\n";
            $html .= '    ' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $html .= "\n    </script>\n";
        }
        return $html;
    }

    /**
     * Reset state (useful between page renders)
     */
    public static function reset(): void
    {
        self::$title = '';
        self::$description = '';
        self::$keywords = '';
        self::$canonical = '';
        self::$robots = 'index, follow';
        self::$og = [];
        self::$twitter = [];
        self::$structuredData = [];
    }
}
