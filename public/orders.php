<?php include '../includes/header.php';
$phone = $_GET['phone'] ?? '';
$email = $_GET['email'] ?? '';
$rows = [];
if($phone || $email){
  $where = [];
  $params = [];
  if($phone){ $where[]='customer_phone=?'; $params[]=$phone; }
  if($email){ $where[]='customer_email=?'; $params[]=$email; }
  $st = db()->prepare('SELECT * FROM orders WHERE '.implode(' AND ', $where).' ORDER BY id DESC');
  $st->execute($params);
  $rows = $st->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2>My Orders</h2>
<p>Find your orders using phone or email used at checkout.</p>
<form method="get" class="card">
  <label>Phone</label><input name="phone" value="<?=e($phone)?>" placeholder="e.g. 5551234567">
  <label>Email</label><input name="email" value="<?=e($email)?>" placeholder="e.g. you@example.com">
  <button class="btn">Search</button>
</form>
<table><tr><th>#</th><th>Name</th><th>Phone</th><th>Status</th><th>Payment</th><th>Total</th><th>Date</th></tr>
<?php foreach($rows as $o): ?><tr><td><?=e($o['order_number'])?></td><td><?=e($o['customer_name'])?></td><td><?=e($o['customer_phone'])?></td><td><?=e($o['status'])?></td><td><?=e($o['payment_status'])?></td><td><?=money($o['total'])?></td><td><?=e($o['created_at'])?></td></tr><?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>
