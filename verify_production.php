<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Post;

echo "DB connection: " . config('database.default') . "\n";
echo "DB name: " . config('database.connections.' . config('database.default') . '.database') . "\n\n";

echo "=== Testimonials (" . Testimonial::count() . " total) ===\n";
foreach (Testimonial::take(10)->get() as $t) {
    echo "#{$t->id}: " . $t->getTranslation('body', 'ar') . "\n";
}

echo "\n=== FAQs (" . Faq::count() . " total) ===\n";
foreach (Faq::all() as $f) {
    echo "#{$f->id}: " . $f->getTranslation('question', 'ar') . "\n";
}

echo "\n=== Posts mentioning AC/refill/split/central (title search) ===\n";
foreach (Post::all() as $p) {
    $t = $p->getTranslation('title', 'en') ?? '';
    if (stripos($t, 'AC') !== false || stripos($t, 'Refill') !== false || stripos($t, 'Split') !== false || stripos($t, 'Central') !== false) {
        echo "#{$p->id}: {$t}\n";
    }
}
