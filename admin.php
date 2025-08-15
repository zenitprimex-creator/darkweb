<?php
session_start();

// Sabit kullanıcı adı ve şifre (hashlenmiş)
$admin_user = "admin";
$admin_pass_hash = password_hash("1234", PASSWORD_DEFAULT); // şifreyi hashle

// Giriş kontrolü
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $admin_user && password_verify($password, $admin_pass_hash)) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Kullanıcı adı veya şifre yanlış!";
    }
}

// Çıkış işlemi
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli</title>
<style>
body { background:#000; color:#0ff; font-family:sans-serif; text-align:center; padding:50px; }
input { padding:10px; margin:5px; border-radius:5px; border:none; }
button { padding:10px 20px; border:none; border-radius:5px; background:#0ff; color:#000; font-weight:bold; cursor:pointer; }
</style>
</head>
<body>

<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    <h2>Admin Paneline Hoşgeldiniz!</h2>
    <p>Burada siteyi yönetebilirsiniz.</p>
    <form method="post"><button name="logout">Çıkış Yap</button></form>
<?php else: ?>
    <h2>Admin Girişi</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post">
        <input type="text" name="username" placeholder="Kullanıcı adı" required><br>
        <input type="password" name="password" placeholder="Şifre" required><br>
        <button name="login">Giriş Yap</button>
    </form>
<?php endif; ?>

</body>
</html>
