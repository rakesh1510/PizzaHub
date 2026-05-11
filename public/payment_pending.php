<?php include '../includes/header.php'; ?>
<section class="section"><div class="wrap card"><h2>Payment Pending</h2>
<p>Your order <b><?=e($_GET['order']??'')?></b> was created with status <b>unpaid</b>.</p>
<p>Stripe Checkout integration is pending setup. Do not mark this order paid until Stripe webhook confirms payment.</p>
<a class="btn" href="orders.php">View My Orders</a></div></section>
<?php include '../includes/footer.php'; ?>
