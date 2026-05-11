<?php include '../includes/header.php';
$slug=$_GET['slug']??'';
$stmt=db()->prepare('SELECT * FROM products WHERE slug=?');$stmt->execute([$slug]);$p=$stmt->fetch(PDO::FETCH_ASSOC);if(!$p){die('Not found');}
$sizes=db()->prepare('SELECT * FROM product_sizes WHERE product_id=?');$sizes->execute([$p['id']]);$sizes=$sizes->fetchAll(PDO::FETCH_ASSOC);
$tops=db()->query('SELECT * FROM toppings WHERE is_active=1')->fetchAll(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $size=$_POST['size_name'];$crust=$_POST['crust'];$qty=max(1,(int)$_POST['qty']);$topIds=$_POST['toppings']??[];
  $sp=db()->prepare('SELECT price FROM product_sizes WHERE product_id=? AND size_name=?');$sp->execute([$p['id'],$size]);$price=(float)$sp->fetchColumn();
  $ins=db()->prepare('INSERT INTO cart(user_id,session_id,product_id,size_name,crust,qty,unit_price) VALUES(?,?,?,?,?,?,?)');
  $ins->execute([currentUser()['id']??null,cartSessionId(),$p['id'],$size,$crust,$qty,$price]);$cartId=db()->lastInsertId();
  foreach($topIds as $tid){$tp=db()->prepare('SELECT extra_price FROM toppings WHERE id=?');$tp->execute([$tid]);$ep=(float)$tp->fetchColumn();db()->prepare('INSERT INTO cart_toppings(cart_id,topping_id,extra_price) VALUES(?,?,?)')->execute([$cartId,$tid,$ep]);}
  header('Location: cart.php');exit;
}
?>
<h2><?=e($p['name'])?></h2><p><?=e($p['description'])?></p>
<form method="post"><label>Size</label><select name="size_name"><?php foreach($sizes as $s): ?><option><?=e($s['size_name'])?></option><?php endforeach; ?></select>
<label>Crust</label><select name="crust"><option>Thin</option><option>Classic</option><option>Cheese crust</option></select>
<label>Extra toppings</label><?php foreach($tops as $t): ?><div><input type="checkbox" name="toppings[]" value="<?=$t['id']?>"> <?=e($t['name'])?> (+<?=money($t['extra_price'])?>)</div><?php endforeach; ?>
<label>Qty</label><input name="qty" type="number" value="1" min="1"><button class="btn">Add to cart</button></form>
<?php include '../includes/footer.php'; ?>
