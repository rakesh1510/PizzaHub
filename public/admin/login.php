<?php require_once '../../config/config.php';
if(isAdmin()){ header('Location: index.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  $st=db()->prepare('SELECT * FROM users WHERE email=? LIMIT 1');$st->execute([trim($_POST['email'])]);$u=$st->fetch(PDO::FETCH_ASSOC);
  if($u && $u['role']==='admin' && password_verify($_POST['password'],$u['password_hash'])){
    session_regenerate_id(true);
    $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
    header('Location: index.php'); exit;
  }
  $err='Invalid credentials';
}
?><!doctype html><html><body><h2>Admin Login</h2><?php if(!empty($err)) echo '<p>'.$err.'</p>'; ?><form method="post"><input name="email" placeholder="Email" required><input type="password" name="password" placeholder="Password" required><button>Login</button></form></body></html>
