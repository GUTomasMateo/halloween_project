<?php
include('conexion.php');
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') die('Acceso denegado.');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $desc = mysqli_real_escape_string($con, $_POST['descripcion']);
    $votos = 0;
    $foto_name = '';

    if (!empty($_FILES['foto']['name']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'. $foto_name);
    }

    $sql = "INSERT INTO disfraces (nombre, descripcion, votos, foto, foto_blob, eliminado) VALUES ('$nombre', '$desc', $votos, '$foto_name', '', 0)";
    if (mysqli_query($con, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        $error = mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Agregar</title><link rel="stylesheet" href="estilos/halloween.css"></head>
<body>
  <h1>Agregar Disfraz</h1>
  <?php if ($error) echo "<p class=\"error\">".htmlspecialchars($error)."</p>"; ?>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <label>Cargar foto (opcional)</label>
    <input type="file" name="foto" accept="image/*">
    <button type="submit">Agregar</button>
  </form>
</body>
</html>
