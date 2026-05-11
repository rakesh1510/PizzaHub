<?php require_once __DIR__.'/../config/config.php';
$cartCountStmt=db()->prepare('SELECT COALESCE(SUM(qty),0) FROM cart WHERE session_id=?');
$cartCountStmt->execute([cartSessionId()]);
$cartCount=(int)$cartCountStmt->fetchColumn();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PizzaHaus | Premium Pizza & Delivery</title>
  <link rel="stylesheet" href="<?=BASE_URL?>/assets/style.css">
</head>
<body>
<header class="site-header">
  <div class="wrap nav-wrap">
    <a class="logo" href="<?=BASE_URL?>/index.php"><span>🍕</span> PizzaHaus</a>
    <button class="menu-toggle" type="button" aria-label="Toggle menu">☰</button>
    <nav class="site-nav">
      <a href="<?=BASE_URL?>/index.php">Home</a>
      <a href="<?=BASE_URL?>/menu.php">Menu</a>
      <a href="<?=BASE_URL?>/about.php">About</a>
      <a href="<?=BASE_URL?>/contact.php">Contact</a>
      <a href="<?=BASE_URL?>/orders.php">My Orders</a>
      <a href="<?=BASE_URL?>/cart.php" class="cart-link">Cart <span class="cart-badge"><?=$cartCount?></span></a>
      <a href="<?=BASE_URL?>/auth/login.php">Login</a>
    </nav>
  </div>
</header>
<main>
