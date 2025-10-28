<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_disfraz'])) {
    $id_usuario = (int)$_SESSION['id_usuario'];
    $id_disfraz = (int)$_POST['id_disfraz'];

    // prevent duplicate votes
    $check = mysqli_query($con, "SELECT id FROM votos WHERE id_usuario=$id_usuario AND id_disfraz=$id_disfraz LIMIT 1");
    if (!$check) { die('Error: '.mysqli_error($con)); }

    if (mysqli_num_rows($check) === 0) {
        mysqli_query($con, "INSERT INTO votos (id_usuario, id_disfraz) VALUES ($id_usuario, $id_disfraz)");
        mysqli_query($con, "UPDATE disfraces SET votos = votos + 1 WHERE id = $id_disfraz");
    }
}

header('Location: index.php');
exit();
?>