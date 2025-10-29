<?php
include("conexion.php");
session_start();

$sql = "SELECT * FROM disfraces WHERE eliminado=0 ORDER BY votos DESC";
$res = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Concurso de Disfraces - Halloween</title>
  <link rel="stylesheet" href="estilos/halloween.css">
</head>
<body>
  <h1>Concurso de Disfraces</h1>
  <div class="topbar">
  <?php
  if (isset($_SESSION['usuario'])) {
      echo "<p>Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . " | <a href='logout.php'>Cerrar sesión</a>";
      if ($_SESSION['usuario'] === 'admin') {
          echo " | <a href='admin.php'>Administración</a>";
      }
      echo "</p>";
  } else {
      echo "<p><a href='login.php'>Iniciar sesión</a> | <a href='registro.php'>Registrarse</a></p>";
  }
  ?>
  </div>

  <div class="lista">
  <?php while ($r = mysqli_fetch_assoc($res)) { ?>
    <div class="disfraz">
      <h2><?php echo htmlspecialchars($r['nombre']); ?></h2>
      <p><?php echo nl2br(htmlspecialchars($r['descripcion'])); ?></p>
      <?php if (!empty($r['foto']) && file_exists("fotos/". $r['foto'])) { ?>
        <img src="fotos/<?php echo htmlspecialchars($r['foto']); ?>" alt="foto" width="200">
      <?php } ?>
      <p class="votos">Votos: <?php echo (int)$r['votos']; ?></p>

      <?php if (isset($_SESSION['id_usuario'])) { ?>
        <form method="post" action="votar.php" class="votarForm">
          <input type="hidden" name="id_disfraz" value="<?php echo (int)$r['id']; ?>">
          <button type="submit">Votar</button>
        </form>
      <?php } else { ?>
        <p><em>Inicia sesión para votar</em></p>
      <?php } ?>
    </div>
  <?php } ?>
  </div>
</body>
</html>
