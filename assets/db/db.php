<?php

$servername = "localhost";
$username = "root";;
$password = "";
$dbname = "filmebom";

// Cria uma nova conexão com o banco de dados
$connect = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($connect->connect_error) {
    die("Erro ao conectar: " . $connect->connect_error);
}

?>