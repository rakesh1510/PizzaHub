<?php require_once '../../config/config.php'; requireAdmin();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $num='PH'.date('Ymd').rand(1000,9999);
  db()->prepare('INSERT INTO orders(order_number,customer_name,customer_phone,customer_address,fulfillment_type,order_source,status,payment_method,payment_status,total,subtotal) VALUES(?,?,?,?,?,?,?,?,?,?,?)')
    ->execute([$num,$_POST['name'],$_POST['phone'],$_POST['address'],$_POST['fulfillment_type'],$_POST['source'],'pending',$_POST['payment_method'],$_POST['payment_status'],$_POST['total'],$_POST['total']]);
}
?><h2>Add Phone/Walk-in Order</h2><form method="post"><input name="name" placeholder="Name"><input name="phone" placeholder="Phone"><textarea name="address"></textarea><select name="fulfillment_type"><option>delivery</option><option>pickup</option></select><select name="source"><option value="phone">phone</option><option value="walkin">walkin</option></select><select name="payment_method"><option value="cod">cod</option><option value="pay_at_restaurant">pay_at_restaurant</option></select><select name="payment_status"><option value="unpaid">unpaid</option><option value="paid">paid</option></select><input name="total" placeholder="Total"><button>Create</button></form>
