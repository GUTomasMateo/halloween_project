<?php
include('conexion.php');
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') die('Acceso denegado.');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = mysqli_query($con, "SELECT * FROM disfraces WHERE id=$id LIMIT 1");
if (!$res || mysqli_num_rows($res) === 0) die('No existe.');

$r = mysqli_fetch_assoc($res);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $desc = mysqli_real_escape_string($con, $_POST['descripcion']);

    if (!empty($_FILES['foto']['name']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'. $foto_name);
        if (!empty($r['foto']) && file_exists('fotos/'.$r['foto'])) unlink('fotos/'.$r['foto']);
        $foto_sql = ", foto='$foto_name'";
    } else {
        $foto_sql = '';
    }

    $sql = "UPDATE disfraces SET nombre='$nombre', descripcion='$desc'".$foto_sql." WHERE id=$id";
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
<head><meta charset="utf-8"><title>Editar</title><link rel="stylesheet" href="estilos/halloween.css"></head>
<body>
  <h1>Editar Disfraz</h1>
  <?php if ($error) echo "<p class=\"error\">".htmlspecialchars($error)."</p>"; ?>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($r['nombre']); ?>" required>
    <textarea name="descripcion" required><?php echo htmlspecialchars($r['descripcion']); ?></textarea>
    <p>Foto actual: <?php echo htmlspecialchars($r['foto']); ?></p>
    <input type="file" name="foto" accept="image/*">
    <button type="submit">Guardar</button>
  </form>
</body>
</html>
