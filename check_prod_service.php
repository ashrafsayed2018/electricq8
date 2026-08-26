<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

echo "Git commit currently deployed: ";
echo trim(shell_exec('git rev-parse HEAD') ?? 'unknown') . "\n\n";

$needle = 'كهربائي 24 ساعة طوارئ';
$service = Service::query()
    ->whereJsonContains('title->ar', $needle)
    ->first();

if (!$service) {
    // fallback: fuzzy search
    $service = Service::all()->first(fn($s) => str_contains($s->getTranslation('title', 'ar') ?? '', '24 ساعة'));
}

if (!$service) {
    echo "Service '{$needle}' not found.\n";
    exit;
}

echo "Found service #{$service->id}: " . $service->getTranslation('title', 'ar') . "\n";
echo "service_type: " . ($service->service_type ?? 'NULL') . "\n\n";

echo "--- faq_schema (ar) ---\n";
echo $service->getTranslation('faq_schema', 'ar') ?: '(empty)';
echo "\n\n--- faq_schema (en) ---\n";
echo $service->getTranslation('faq_schema', 'en') ?: '(empty)';

echo "\n\n--- content (ar) first 2000 chars ---\n";
echo substr(strip_tags($service->getTranslation('content', 'ar') ?? ''), 0, 2000);

echo "\n\n--- Does content/faq contain AC terms? ---\n";
$haystack = ($service->getTranslation('content', 'ar') ?? '') . ($service->getTranslation('faq_schema', 'ar') ?? '');
foreach (['سبليت', 'مركزي', 'كاريير', 'سامسونج', 'دايكن', 'ميديا', 'جري', 'توشيبا'] as $term) {
    if (str_contains($haystack, $term)) {
        echo "FOUND: {$term}\n";
    }
}
