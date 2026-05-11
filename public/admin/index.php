<?php require_once '../../config/config.php'; requireAdmin();
$rev=db()->query('SELECT COALESCE(SUM(total),0) FROM orders WHERE payment_status="paid"')->fetchColumn();
$orders=db()->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$products=db()->query('SELECT COUNT(*) FROM products')->fetchColumn();
$customers=db()->query('SELECT COUNT(*) FROM users WHERE role="customer"')->fetchColumn();
?><h2>Dashboard</h2><p>Revenue: <?=money($rev)?> | Orders: <?=$orders?> | Products: <?=$products?> | Customers: <?=$customers?></p>
<p><a href="products.php">Products</a> | <a href="categories.php">Categories</a> | <a href="toppings.php">Toppings</a> | <a href="orders.php">Orders</a> | <a href="offline_order.php">Add Offline Order</a> | <a href="logout.php">Logout</a></p>
