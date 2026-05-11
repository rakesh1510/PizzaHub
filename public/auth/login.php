<?php include '../../includes/header.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $st=db()->prepare('SELECT * FROM users WHERE email=? LIMIT 1');$st->execute([trim($_POST['email'])]);$u=$st->fetch(PDO::FETCH_ASSOC);
 if($u && password_verify($_POST['password'],$u['password_hash'])){$_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];header('Location: ../index.php');exit;}
 $msg='Invalid login';
}
?>
<section class="section"><div class="wrap card"><h2>Login</h2><?php if($msg) echo '<p>'.$msg.'</p>'; ?><form method="post"><input name="email" type="email" placeholder="Email" required><input name="password" type="password" placeholder="Password" required><button class="btn">Login</button></form><p>New here? <a href="register.php">Create account</a></p></div></section>
<?php include '../../includes/footer.php'; ?>
