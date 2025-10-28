<?php
include('conexion.php');
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    die('Acceso denegado. Debes ser admin.');
}

$res = mysqli_query($con, "SELECT * FROM disfraces ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Admin</title><link rel="stylesheet" href="estilos/halloween.css"></head>
<body>
  <h1>Panel de Administración</h1>
  <p><a href="agregar_disfraz.php">Agregar disfraz</a> | <a href="index.php">Volver</a></p>
  <div class="admin-list">
  <?php while ($r = mysqli_fetch_assoc($res)) { ?>
    <div class="admin-item">
      <strong><?php echo htmlspecialchars($r['nombre']); ?></strong>
      <div class="actions">
        <a href="editar_disfraz.php?id=<?php echo (int)$r['id']; ?>">Editar</a> |
        <a href="eliminar_disfraz.php?id=<?php echo (int)$r['id']; ?>" onclick="return confirm('Eliminar?');">Eliminar</a>
      </div>
    </div>
  <?php } ?>
  </div>
</body>
</html>
