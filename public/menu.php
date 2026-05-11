<?php include '../includes/header.php';
$cats = db()->query('SELECT * FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$products = db()->query('SELECT p.*, c.name category FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section"><div class="wrap"><h1>Pizza Menu</h1><p>Crafted with premium ingredients.</p><input id="menuSearch" placeholder="Search pizza..." class="search"></div></section>
<?php foreach($cats as $c): ?><section class="section"><div class="wrap"><h2><?=e($c['name'])?></h2><div class="grid"><?php foreach($products as $p): if($p['category_id']!=$c['id']) continue; ?><article class="card product-card"><h3><?=e($p['name'])?></h3><p><?=e($p['description'])?></p><p><span class="price-badge">From <?=money($p['base_price'])?></span></p><a class="btn" href="pizza.php?slug=<?=e($p['slug'])?>">Customize & Order</a></article><?php endforeach; ?></div></div></section><?php endforeach; ?>
<?php include '../includes/footer.php'; ?>
