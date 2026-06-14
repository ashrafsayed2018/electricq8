<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Post;
use App\Models\Service;
use App\Models\ServiceLocationPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $now  = now()->toAtomString();

        $urls = [];

        // Helper
        $add = function (string $ar, string $en, float $priority, string $freq, string $date = null) use (&$urls, $base, $now) {
            $d = $date ?? $now;
            $urls[] = ['loc' => $base . $ar, 'priority' => $priority, 'freq' => $freq, 'date' => $d];
            $urls[] = ['loc' => $base . $en, 'priority' => $priority, 'freq' => $freq, 'date' => $d];
        };

        // Static
        $add('/',         '/en',          1.0, 'daily');
        $add('/services', '/en/services', 0.9, 'weekly');
        $add('/areas',    '/en/areas',    0.9, 'weekly');
        $add('/blog',     '/en/blog',     0.8, 'daily');
        $add('/about',    '/en/about',    0.7, 'weekly');
        $add('/contact',  '/en/contact',  0.7, 'weekly');

        // Services
        foreach (Service::active()->get() as $s) {
            $add(
                '/services/' . $s->getTranslation('slug', 'ar'),
                '/en/services/' . $s->getTranslation('slug', 'en'),
                0.9, 'monthly',
                $s->updated_at?->toAtomString()
            );
        }

        // Areas
        foreach (Location::where('is_active', true)->get() as $a) {
            $add(
                '/areas/' . $a->getTranslation('slug', 'ar'),
                '/en/areas/' . $a->getTranslation('slug', 'en'),
                0.8, 'monthly',
                $a->updated_at?->toAtomString()
            );
        }

        // Blog
        foreach (Post::published()->get() as $p) {
            $add(
                '/blog/' . $p->getTranslation('slug', 'ar'),
                '/en/blog/' . $p->getTranslation('slug', 'en'),
                0.7, 'weekly',
                ($p->published_at ?? $p->updated_at)?->toAtomString()
            );
        }

        // Service × Location (indexed only)
        ServiceLocationPage::where('status', 'active')
            ->where('noindex', false)
            ->with(['service', 'location'])
            ->chunk(200, function ($pages) use ($add, $now) {
                foreach ($pages as $page) {
                    $add(
                        '/services/' . $page->service->getTranslation('slug', 'ar') . '/' . $page->location->getTranslation('slug', 'ar'),
                        '/en/services/' . $page->service->getTranslation('slug', 'en') . '/' . $page->location->getTranslation('slug', 'en'),
                        0.9, 'monthly',
                        $page->updated_at?->toAtomString()
                    );
                }
            });

        // Build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n";
            $xml .= '    <lastmod>' . $u['date'] . "</lastmod>\n";
            $xml .= '    <changefreq>' . $u['freq'] . "</changefreq>\n";
            $xml .= '    <priority>' . number_format($u['priority'], 1) . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
