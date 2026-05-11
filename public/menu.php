<?php include '../includes/header.php';
$cats = db()->query('SELECT * FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$products = db()->query('SELECT p.*, c.name category FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Pizza Menu</h2>
<?php foreach($cats as $c): ?>
<h3><?=e($c['name'])?></h3><div class="grid">
<?php foreach($products as $p): if($p['category_id']!=$c['id']) continue; ?>
<div class="card"><h4><?=e($p['name'])?></h4><p><?=e($p['description'])?></p><p>From <?=money($p['base_price'])?></p><a class="btn" href="pizza.php?slug=<?=e($p['slug'])?>">View</a></div>
<?php endforeach; ?></div>
<?php endforeach; include '../includes/footer.php'; ?>
