<?php include '../../includes/header.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=trim($_POST['name']);$email=trim($_POST['email']);$phone=trim($_POST['phone']);$pw=password_hash($_POST['password'],PASSWORD_DEFAULT);
 try{db()->prepare('INSERT INTO users(name,email,phone,password_hash,role) VALUES(?,?,?,?,"customer")')->execute([$name,$email,$phone,$pw]);$msg='Registered! Please login.';}catch(Exception $e){$msg='Email already exists.';}
}
?>
<section class="section"><div class="wrap card"><h2>Register</h2><?php if($msg) echo '<p>'.$msg.'</p>'; ?><form method="post"><input name="name" placeholder="Name" required><input name="email" type="email" placeholder="Email" required><input name="phone" placeholder="Phone"><input name="password" type="password" placeholder="Password" required><button class="btn">Create Account</button></form></div></section>
<?php include '../../includes/footer.php'; ?>
