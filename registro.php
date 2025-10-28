<?php
include("conexion.php");
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre']) && !empty($_POST['clave'])) {
        $nombre = mysqli_real_escape_string($con, trim($_POST['nombre']));
        $clave_raw = $_POST['clave'];

        // check if user exists
        $chk = mysqli_query($con, "SELECT id FROM usuarios WHERE nombre='$nombre' LIMIT 1");
        if (mysqli_num_rows($chk) > 0) {
            $error = "El nombre de usuario ya existe.";
        } else {
            $hash = password_hash($clave_raw, PASSWORD_BCRYPT);
            mysqli_query($con, "INSERT INTO usuarios (nombre, clave) VALUES ('$nombre', '$hash')");
            header('Location: login.php');
            exit();
        }
    } else {
        $error = "Completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Registro</title><link rel="stylesheet" href="estilos/halloween.css"></head>
<body>
  <h1>🎃 Registro de Usuario</h1>
  <?php if ($error) echo "<p class=\"error\">".htmlspecialchars($error)."</p>"; ?>
  <form method="post" autocomplete="off">
    <input type="text" name="nombre" placeholder="Nombre de usuario" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
  </form>
  <p><a href="login.php">Ir a inicio de sesión</a></p>
</body>
</html>
