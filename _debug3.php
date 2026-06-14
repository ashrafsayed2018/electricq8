<?php
putenv("APP_ENV=testing");
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE=:memory:");
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check the middleware alias is registered
$router = $app->make(\Illuminate\Routing\Router::class);
// Check all routes for /en/services/{service}
foreach ($router->getRoutes()->getRoutes() as $route) {
    if (str_contains($route->uri(), "en/services")) {
        echo "Route: " . $route->uri() . "\n";
        echo "Middleware: " . implode(", ", $route->gatherMiddleware()) . "\n";
        break;
    }
}