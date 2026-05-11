<?php include '../includes/header.php';
$items=db()->prepare('SELECT * FROM cart WHERE session_id=?');$items->execute([cartSessionId()]);$items=$items->fetchAll(PDO::FETCH_ASSOC);if(!$items){die('Cart empty');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']);$email=trim($_POST['email']);$phone=trim($_POST['phone']);$addr=trim($_POST['address']);$ful=$_POST['fulfillment_type'];$pay=$_POST['payment_method'];
  if(!$name || !$phone){$error='Name and phone are required.';}
  if($ful==='delivery' && !$addr){$error='Address is required for delivery.';}
  if(!$error){
    $subtotal=0; foreach($items as $i){$tops=db()->prepare('SELECT SUM(extra_price) FROM cart_toppings WHERE cart_id=?');$tops->execute([$i['id']]);$subtotal+=(($i['unit_price']+(float)$tops->fetchColumn())*$i['qty']);}
    $del=($ful==='delivery')?4.99:0; $total=$subtotal+$del; $num='PH'.date('Ymd').rand(1000,9999);
    $paymentStatus = 'unpaid';
    db()->prepare('INSERT INTO orders(order_number,user_id,customer_name,customer_email,customer_phone,customer_address,fulfillment_type,payment_method,subtotal,delivery_fee,total,order_source,payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)')
      ->execute([$num,currentUser()['id']??null,$name,$email,$phone,$addr,$ful,$pay,$subtotal,$del,$total,'online',$paymentStatus]);
    $oid=db()->lastInsertId();
    foreach($items as $i){$tops=db()->prepare('SELECT t.name,ct.extra_price FROM cart_toppings ct JOIN toppings t ON t.id=ct.topping_id WHERE cart_id=?');$tops->execute([$i['id']]);$tops=$tops->fetchAll(PDO::FETCH_ASSOC);$topTotal=array_sum(array_column($tops,'extra_price'));$line=(($i['unit_price']+$topTotal)*$i['qty']);
      db()->prepare('INSERT INTO order_items(order_id,product_id,product_name,size_name,crust,qty,unit_price,line_total) SELECT ?,p.id,p.name,?,?,?,?,? FROM products p WHERE p.id=?')->execute([$oid,$i['size_name'],$i['crust'],$i['qty'],$i['unit_price'],$line,$i['product_id']]);$oi=db()->lastInsertId();
      foreach($tops as $t){db()->prepare('INSERT INTO order_item_toppings(order_item_id,topping_name,extra_price) VALUES(?,?,?)')->execute([$oi,$t['name'],$t['extra_price']]);}
    }
    if($pay==='stripe'){ db()->prepare('INSERT INTO payments(order_id,provider,amount,status) VALUES(?,?,?,?)')->execute([$oid,'stripe',$total,'pending']); header('Location: payment_pending.php?order='.$num.'&payment=required&method=stripe'); exit; }
    $offlineProvider = in_array($pay,['cod','pay_at_restaurant'],true) ? 'cash' : 'cash';
    db()->prepare('INSERT INTO payments(order_id,provider,amount,status) VALUES(?,?,?,?)')->execute([$oid,$offlineProvider,$total,'pending']);
    db()->prepare('DELETE FROM cart WHERE session_id=?')->execute([cartSessionId()]);
    header('Location: order_success.php?order='.$num.'&payment=pending');exit;
  }
}
?>
<section class="section"><div class="wrap"><h1>Checkout</h1><?php if($error): ?><p style="color:#c62828"><?=e($error)?></p><?php endif; ?>
<div class="grid"><form method="post" class="card checkout-form"><input name="name" placeholder="Name" required><input name="email" type="email" placeholder="Email"><input name="phone" placeholder="Phone" required><textarea name="address" placeholder="Address"></textarea>
<label>Delivery/Pickup</label><select name="fulfillment_type"><option value="delivery">Delivery</option><option value="pickup">Pickup</option></select>
<label>Payment</label><select name="payment_method"><option value="stripe">Stripe card payment (Checkout)</option><option value="cod">Cash on delivery</option><option value="pay_at_restaurant">Pay at restaurant</option></select>
<p class="note">Payment status stays <strong>unpaid</strong> until money is collected/confirmed.</p><button class="btn">Place Order</button></form>
<div class="card"><h3>Order Summary</h3><p>Delivery fee applies only to delivery orders.</p><p>For Stripe, you will be redirected to payment flow before confirmation.</p></div></div></div></section>
<?php include '../includes/footer.php'; ?>
