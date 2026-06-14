<?php
putenv("APP_ENV=testing");
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE=:memory:");
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
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

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::create("/en/services/ac-cleaning","GET");
$response = $kernel->handle($request);
echo "Status: ".$response->getStatusCode()."\n";
echo "Locale: ".app()->getLocale()."\n";