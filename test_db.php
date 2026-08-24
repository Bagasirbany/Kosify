<?php
$host = 'db.fhsauyiiuebhkeenvlah.supabase.co';
$db = 'postgres';
$user = 'postgres';
$pass = '6F4yNZE00IFnJlMn';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected successfully to PostgreSQL!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
