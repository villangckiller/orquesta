<?php session_start();
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    // usuario y clave de ejemplo
    if ($user === 'admin' && $pass === '1234') {
        $_SESSION['usuario_admin'] = $user;
        header("Location: upload.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
<h2>Login de administrador</h2>
<form method="post">
    Usuario: <input type="text" name="usuario"><br><br>
    Contraseña: <input type="password" name="password"><br><br>
    <input type="submit" value="Entrar">
</form>