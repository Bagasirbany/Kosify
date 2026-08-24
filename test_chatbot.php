<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/chatbot/message', 'POST', ['message' => 'berapa harga kamar?']);
$controller = new App\Http\Controllers\ChatbotController();

try {
    $response = $controller->respond($request);
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Content:\n" . $response->getContent() . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
