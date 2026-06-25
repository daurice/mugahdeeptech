<?php
require_once __DIR__ . '/../includes/academy-header.php';
$errors=[]; $values=['full_name'=>'','email'=>'','phone'=>''];
if ($_SERVER['REQUEST_METHOD']==='POST') {
 if (!verify_csrf($_POST['csrf_token'] ?? null)) { $errors[]='Security check failed.'; }
 foreach ($values as $k=>$_) { $values[$k]=trim((string)($_POST[$k] ?? '')); }
 $password=(string)($_POST['password'] ?? '');
 if (strlen($values['full_name'])<2) $errors[]='Enter your full name.';
 if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[]='Enter a valid email.';
 if (strlen($password)<8) $errors[]='Use at least 8 password characters.';
 if (!$errors) { try { $stmt=$pdo->prepare('INSERT INTO learners (full_name,email,phone,password_hash) VALUES (:n,:e,:p,:h)'); $stmt->execute([':n'=>$values['full_name'],':e'=>$values['email'],':p'=>$values['phone'],':h'=>password_hash($password,PASSWORD_DEFAULT)]); $_SESSION['learner_id']=(int)$pdo->lastInsertId(); $_SESSION['learner_name']=$values['full_name']; header('Location: dashboard.php'); exit; } catch (PDOException $e) { $errors[]='That email is already registered.'; } }
}
?>
<section class="auth-section"><form class="glass-card login-card" method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>"><p class="eyebrow">Join Academy</p><h1>Create Learner Account</h1><?php if($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)); ?></div><?php endif; ?><label>Full Name</label><input class="form-control mb-3" name="full_name" value="<?= e($values['full_name']); ?>" required><label>Email</label><input class="form-control mb-3" type="email" name="email" value="<?= e($values['email']); ?>" required><label>Phone</label><input class="form-control mb-3" name="phone" value="<?= e($values['phone']); ?>"><label>Password</label><input class="form-control mb-4" type="password" name="password" required><button class="btn btn-premium w-100">Create Account</button><p class="mt-3">Already registered? <a href="login.php">Login</a></p></form></section>
<?php include __DIR__ . '/../includes/academy-footer.php'; ?>