<?php
putenv("APP_ENV=testing");
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE=:memory:");
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
\Illuminate\Support\Facades\Artisan::call("migrate");

\App\Models\SiteSetting::create(["key"=>"whatsapp_number","value"=>"96512345678","group"=>"contact"]);
\App\Models\SiteSetting::create(["key"=>"phone_number","value"=>"+965","group"=>"contact"]);
\App\Models\SiteSetting::create(["key"=>"site_name_ar","value"=>"كول","group"=>"seo"]);
\App\Models\SiteSetting::create(["key"=>"site_name_en","value"=>"ElectricQ8","group"=>"seo"]);
\App\Models\SiteSetting::create(["key"=>"default_meta_ar","value"=>"كهرباء","group"=>"seo"]);
\App\Models\SiteSetting::create(["key"=>"default_meta_en","value"=>"AC","group"=>"seo"]);

\App\Models\Service::create([
    "name"=>["ar"=>"تنظيف الكهرباء","en"=>"AC Cleaning"],
    "slug"=>["ar"=>"تنظيف-كهرباء","en"=>"ac-cleaning"],
    "short_desc"=>["ar"=>"وصف","en"=>"Short"],
    "description"=>["ar"=>"كامل","en"=>"Full"],
    "status"=>"active",
    "sort_order"=>1,
]);

// Patch the middleware to add debugging
app()->singleton(\App\Http\Middleware\SetLocale::class, function() {
    return new class {
        public function handle($request, $next) {
            $segment = $request->segment(1);
            echo "MIDDLEWARE: segment1=" . $segment . "\n";
            if (in_array($segment, config("app.available_locales"))) {
                app()->setLocale($segment);
                echo "MIDDLEWARE: set locale to " . $segment . "\n";
            } else {
                app()->setLocale(session("locale", "ar"));
                echo "MIDDLEWARE: using session/default ar\n";
            }
            return $next($request);
        }
    };
});

$httpKernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::create("/en/services/ac-cleaning","GET");
$response = $httpKernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";