<?php require_once '../../config/config.php'; requireAdmin();
$statuses=['pending','preparing','ready','out_for_delivery','delivered','cancelled'];
$payStatuses=['unpaid','paid','refunded'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(in_array($_POST['status'],$statuses,true) && in_array($_POST['payment_status'],$payStatuses,true)){
    db()->prepare('UPDATE orders SET status=?,payment_status=? WHERE id=?')->execute([$_POST['status'],$_POST['payment_status'],$_POST['id']]);
  }
}
$where='1=1';$params=[];
if(!empty($_GET['status']) && in_array($_GET['status'],$statuses,true)){$where.=' AND status=?';$params[]=$_GET['status'];}
if(!empty($_GET['phone'])){$where.=' AND customer_phone LIKE ?';$params[]='%'.$_GET['phone'].'%';}
if(!empty($_GET['date'])){$where.=' AND DATE(created_at)=?';$params[]=$_GET['date'];}
$st=db()->prepare("SELECT * FROM orders WHERE $where ORDER BY id DESC");$st->execute($params);$rows=$st->fetchAll(PDO::FETCH_ASSOC);
?><h2>Orders</h2><form><input type="date" name="date" value="<?=e($_GET['date']??'') ?>"><input name="phone" placeholder="Phone" value="<?=e($_GET['phone']??'')?>"><select name="status"><option value="">Any status</option><?php foreach($statuses as $s): ?><option value="<?=$s?>" <?=($s===($_GET['status']??''))?'selected':''?>><?=$s?></option><?php endforeach; ?></select><button>Filter</button></form>
<table><tr><th>#</th><th>Customer</th><th>Status</th><th>Payment</th><th>Total</th><th>Action</th><th>Print</th></tr><?php foreach($rows as $r): ?><tr><td><?=$r['order_number']?></td><td><?=e($r['customer_name'])?> (<?=e($r['customer_phone'])?>)</td><td><?=$r['status']?></td><td><?=$r['payment_status']?></td><td><?=money($r['total'])?></td><td><form method="post" class="inline"><input type="hidden" name="id" value="<?=$r['id']?>"><select name="status"><?php foreach($statuses as $s): ?><option value="<?=$s?>" <?=$s===$r['status']?'selected':''?>><?=$s?></option><?php endforeach; ?></select><select name="payment_status"><?php foreach($payStatuses as $s): ?><option value="<?=$s?>" <?=$s===$r['payment_status']?'selected':''?>><?=$s?></option><?php endforeach; ?></select><button>Update</button></form></td><td><a target="_blank" href="print_ticket.php?id=<?=$r['id']?>">Kitchen Ticket</a> | <a target="_blank" href="print_receipt.php?id=<?=$r['id']?>">Receipt</a></td></tr><?php endforeach; ?></table>
