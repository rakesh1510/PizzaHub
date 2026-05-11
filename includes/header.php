<?php require_once __DIR__.'/../config/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PizzaHaus</title>
  <link rel="stylesheet" href="<?=BASE_URL?>/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="wrap nav">
    <a class="logo" href="<?=BASE_URL?>/index.php">🍕 PizzaHaus</a>
    <nav>
      <a href="<?=BASE_URL?>/index.php">Home</a>
      <a href="<?=BASE_URL?>/about.php">About</a>
      <a href="<?=BASE_URL?>/menu.php">Menu</a>
      <a href="<?=BASE_URL?>/contact.php">Contact</a>
      <a href="<?=BASE_URL?>/cart.php">Cart</a>
      <a href="<?=BASE_URL?>/orders.php">My Orders</a>
      <a href="<?=BASE_URL?>/auth/login.php">Login</a>
      <a href="<?=BASE_URL?>/admin/login.php">Admin</a>
    </nav>
  </div>
</header>
