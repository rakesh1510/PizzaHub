<?php include '../includes/header.php';
if(isset($_POST['update'])){ foreach($_POST['qty'] as $id=>$q){ db()->prepare('UPDATE cart SET qty=? WHERE id=? AND session_id=?')->execute([max(1,(int)$q),$id,cartSessionId()]); } }
if(isset($_GET['remove'])){ db()->prepare('DELETE FROM cart WHERE id=? AND session_id=?')->execute([$_GET['remove'],cartSessionId()]); }
$rows=db()->prepare('SELECT c.*,p.name FROM cart c JOIN products p ON p.id=c.product_id WHERE c.session_id=?');$rows->execute([cartSessionId()]);$rows=$rows->fetchAll(PDO::FETCH_ASSOC);
$subtotal=0;
?>
<section class="section"><div class="wrap"><h1>Your Cart</h1><form method="post" class="card"><table><tr><th>Item</th><th>Qty</th><th>Price</th><th></th></tr>
<?php foreach($rows as $r): $tops=db()->prepare('SELECT t.name,ct.extra_price FROM cart_toppings ct JOIN toppings t ON t.id=ct.topping_id WHERE ct.cart_id=?');$tops->execute([$r['id']]);$tops=$tops->fetchAll(PDO::FETCH_ASSOC);$topTotal=array_sum(array_column($tops,'extra_price'));$line=($r['unit_price']+$topTotal)*$r['qty'];$subtotal+=$line; ?>
<tr><td><?=e($r['name'])?> (<?=e($r['size_name'])?>, <?=e($r['crust'])?>)</td><td><input type="number" name="qty[<?=$r['id']?>]" value="<?=$r['qty']?>" min="1"></td><td><?=money($line)?></td><td><a href="?remove=<?=$r['id']?>">Remove</a></td></tr>
<?php endforeach; ?></table><button name="update" class="btn">Update Cart</button></form>
<div class="card order-summary"><h3>Order Summary</h3><p>Subtotal: <b><?=money($subtotal)?></b></p><a class="btn" href="checkout.php">Checkout</a></div></div></section>
<?php include '../includes/footer.php'; ?>
