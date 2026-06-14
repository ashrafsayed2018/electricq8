<?php
putenv("APP_ENV=testing");
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE=:memory:");
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$request = \Illuminate\Http\Request::create("/en/services/ac-cleaning","GET");
echo "Segment 1: " . $request->segment(1) . "\n";
echo "Segment 2: " . $request->segment(2) . "\n";
echo "Segment 3: " . $request->segment(3) . "\n";
echo "Available locales: " . implode(",", config("app.available_locales", [])) . "\n";
echo "In array check: " . (in_array("en", config("app.available_locales", [])) ? "YES" : "NO") . "\n";