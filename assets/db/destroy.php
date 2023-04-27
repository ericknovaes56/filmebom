<?php

require_once 'db.php';
session_start();

if (!isset($_SESSION['logado'])){
    header('location:../../');
};
if (isset($_SESSION['logado'])){
    $id = $_SESSION['id_user'];
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($connect , $sql);
    $dadosall = mysqli_fetch_array($result);
    $dadosall['img'] = '../' . $dadosall['img'];
};

$sql = "DELETE FROM user WHERE id=".$dadosall['id'];
$result = mysqli_query($connect , $sql);

session_start();
session_unset();
session_destroy();

header("location:../../")

?>