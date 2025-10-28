<?php
include('conexion.php');
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') die('Acceso denegado.');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = mysqli_query($con, "SELECT * FROM disfraces WHERE id=$id LIMIT 1");
if ($res && mysqli_num_rows($res) === 1) {
    $r = mysqli_fetch_assoc($res);
    if (!empty($r['foto']) && file_exists('fotos/'.$r['foto'])) unlink('fotos/'.$r['foto']);
    mysqli_query($con, "DELETE FROM votos WHERE id_disfraz=$id");
    mysqli_query($con, "DELETE FROM disfraces WHERE id=$id");
}
header('Location: admin.php');
exit();
?>