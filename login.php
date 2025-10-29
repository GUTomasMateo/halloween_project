<?php
include("conexion.php");
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($con, trim($_POST['nombre']));
    $clave = $_POST['clave'];

    $res = mysqli_query($con, "SELECT * FROM usuarios WHERE nombre='$nombre' LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        $user = mysqli_fetch_assoc($res);
        if (password_verify($clave, $user['clave'])) {
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['id_usuario'] = (int)$user['id'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="estilos/halloween.css"></head>
<body>
    <h1>🎃 Iniciar sesión</h1>
    <?php if ($error) echo "<p class=\"error\">".htmlspecialchars($error)."</p>"; ?>
    <form method="post" autocomplete="off">
        <input type="text" name="nombre" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    <p><a href="registro.php">Registrarse</a></p>
</body>
</html>
