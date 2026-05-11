<?php include '../includes/header.php';
$cats = db()->query('SELECT * FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$products = db()->query('SELECT p.*, c.name category FROM products p JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);
$quickCats=['Classic','Veggie','BBQ','Pasta','Desserts','Drinks'];
?>

<section class="menu-hero">
  <div class="wrap">
    <h1>Hot &amp; Fresh Pizza Delivered Fast</h1>
    <p>Order your favorite pizzas online for delivery or pickup.</p>
    <a class="btn" href="#menu-grid">Order Now</a>
  </div>
</section>
<section class="info-strip"><div class="wrap"><span>Fresh Ingredients</span><span>Fast Delivery</span><span>Pickup Available</span><span>Secure Checkout</span></div></section>
<section class="category-tabs"><div class="wrap"><?php foreach($quickCats as $qc): ?><a href="#menu-grid" class="tab-pill"><?=e($qc)?></a><?php endforeach; ?></div></section>
<section class="section" id="menu-grid"><div class="wrap"><h2>Explore Our Menu</h2><input id="menuSearch" placeholder="Search pizza, pasta, drinks..." class="search">
<?php foreach($cats as $c): ?>
  <div class="menu-cat-block"><h3><?=e($c['name'])?></h3><div class="menu-grid">
  <?php foreach($products as $p): if($p['category_id']!=$c['id']) continue; ?>
    <article class="menu-card product-card">
      <div class="product-thumb" aria-hidden="true">🍕</div>
      <div class="menu-card-body">
        <span class="pop-badge">Popular</span>
        <h4><?=e($p['name'])?></h4>
        <p><?=e($p['description'])?></p>
        <div class="menu-card-footer"><span class="price-badge">From <?=money($p['base_price'])?></span><a class="btn" href="pizza.php?slug=<?=e($p['slug'])?>">Customize &amp; Order</a></div>
      </div>
    </article>
  <?php endforeach; ?>
  </div></div>
<?php endforeach; ?>
</div></section>
<a class="mobile-cart-cta" href="cart.php">View Cart</a>

<?php include '../includes/footer.php'; ?>
