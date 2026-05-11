<?php
session_start();

define('DB_HOST','127.0.0.1');
define('DB_NAME','pizzahaus');
define('DB_USER','root');
define('DB_PASS','');
define('BASE_URL','/public');
define('STRIPE_SECRET_KEY','sk_test_replace_me');
define('STRIPE_WEBHOOK_SECRET','whsec_replace_me');

define('STRIPE_PRICE_CURRENCY','usd');

function db(){
    static $pdo;
    if(!$pdo){
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    return $pdo;
}

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function cartSessionId(){ return session_id(); }
function isAdmin(){ return !empty($_SESSION['user']) && $_SESSION['user']['role']==='admin'; }
function requireAdmin(){ if(!isAdmin()){ header('Location: '.BASE_URL.'/admin/login.php'); exit; } }
function currentUser(){ return $_SESSION['user'] ?? null; }
function money($n){ return '$'.number_format((float)$n,2); }
?>
