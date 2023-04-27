<?php
    
    require_once '../assets/db/db.php';
    session_start();
    if (!isset($_SESSION['logado'])){
        header('location:../');
    };
    if (isset($_SESSION['logado'])){
        $id = $_SESSION['id_user'];
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = mysqli_query($connect , $sql);
        $dadosall = mysqli_fetch_array($result);
        $dadosall['img'] = '../' . $dadosall['img'];
    };
    if(isset($_POST['submit'])){
        $nome = mysqli_escape_string($connect , $_POST['nome']);
        $trailer = mysqli_escape_string($connect , $_POST['trailer']);
        $link = mysqli_escape_string($connect , $_POST['link']);
        $select = mysqli_escape_string($connect , $_POST['select']);
        $app = mysqli_escape_string($connect , $_POST['app']);
        $dodia = mysqli_escape_string($connect , $_POST['dodia']);
        $descricao = mysqli_escape_string($connect , $_POST['descricao']);

        if(!empty($_FILES['capa']) && !empty($trailer) && !empty($link) && $select != 'categoria' && $app != 'app' && !empty($descricao)){
            $formatosPermitidos= array("png", "jpeg", "jpg", "gif");
            $extensao=pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
            if(in_array($extensao, $formatosPermitidos)){
                $varid = $dadosall['id'];
                $pasta="assets/img/conteudos/";
                $pasta2="../assets/img/conteudos";
                $move="../assets/img/conteudos/";
                if (!is_dir($pasta2)){
                    mkdir($pasta2, 0777, true);
                }
                $temporario= $_FILES['capa']['tmp_name'];
                $novoNome=uniqid().".$extensao";
                if(move_uploaded_file($temporario, $move. $novoNome)){
                    $mensagem[]="Upload feito com sucesso!";
                    $salvarnobanco = $pasta. $novoNome;
                    if ($dodia == 'on'){
                        $sql = "SELECT * FROM conteudo WHERE dodia = 'on'";
                        $result = mysqli_query($connect, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id']; // supondo que a tabela tenha uma coluna chamada "id"
                                $sql_desativar = "UPDATE conteudo SET dodia = 'off' WHERE id = '$id'";
                                mysqli_query($connect, $sql_desativar);
                            }
                        }
                    }
                    $dadosall = mysqli_fetch_array($result);
                    $sql = "INSERT INTO conteudo (nome,capa,trailer,link,categoria,dodia,descricao,stream) VALUES ('$nome','$salvarnobanco','$trailer','$link','$select','$dodia','$descricao','$app')";
                    $result = mysqli_query($connect, $sql);
                    header('location:upload.php');
                }else{
                    echo 'erro';
                }
            }else{
                $erros[] = "Formato Invalido";
            }
        }else{
            $erros[] = "img Não Foi Alterada !<br>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Login - FilmeBom</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
<nav class="menu">
    <div class="msg">
        <?php

                if (!empty($erros)) {
                    foreach ($erros as $erro) {
                        echo '
                        <div class="box">
                            <img src="../assets/img/logo.png">
                            <span>' . $erro . '</span>
                        </div>';
                    }
                }
            
            ?>
        </div>
        <div class="fist">
            <div class="buguer">
                <i class='bx bx-menu'></i>
            </div>
            <div class="logo">
                FilmeBom
            </div>
        </div>
        <div class="navigator">
        <?php
            if (isset($_SESSION['logado'])){
                if ($dadosall['cargo'] != 'user'){
                    echo
                    '
                    <div class="perfil">
                    <label for="floatmenu">
                        <div class="foto">
                            <img src="'.$dadosall['img'].'">
                        </div>
                    </label>
                    <input type="checkbox" id="floatmenu">
                    <div class="floatmenu">
                        <div class="user">
                            <img src="'.$dadosall['img'].'">
                            <div>
                                <h1>'.$dadosall['nome'].'</h1>
                                <span>Cargo: '.$dadosall['cargo'].'</span>
                            </div>
                        </div>
                        <ul class="navi">
                            <li><a href="../">Inicio</a></li>
                            <li><a href="perfil.php?locate=favoritos">Favoritos</a></li>
                            <li><a href="#">Upload</a></li>
                            <li><a href="#">Pagina de Controle</a></li>
                        </ul>
                        <div class="sair">
                            <a href="../assets/db/sair.php">Sair Da Conta</a>
                        </div>
                    </div>
                </div>
            </div>
                   ';
                }else{
                    echo
                    '
                    <div class="perfil">
                    <label for="floatmenu">
                        <div class="foto">
                            <img src="'.$dadosall['img'].'">
                        </div>
                    </label>
                    <input type="checkbox" id="floatmenu">
                    <div class="floatmenu">
                        <div class="user">
                            <img src="'.$dadosall['img'].'">
                            <div>
                                <h1>'.$dadosall['nome'].'</h1>
                                <span>Cargo: '.$dadosall['cargo'].'</span>
                            </div>
                        </div>
                        <ul class="navi">
                            <li><a href="../">Inicio</a></li>
                            <li><a href="perfil.php?locate=favoritos">Favoritos</a></li>
                        </ul>
                        <div class="sair">
                            <a href="../assets/db/sair.php">Sair Da Conta</a>
                        </div>
                    </div>
                </div>
            </div>
                   ';
                }
                }else{
                    echo '
                    <div class="login">
                        <a href="page/login.php">
                            <input type="button" value="Fazer Login">
                        </a>
                    </div>
                    
                    ';
                }
            ?>
    </nav>
    <section class="perfils">
        <div class="uploadbox">
            <div class="img">
                <i class='bx bx-loader-alt bx-spin bx-rotate-90' ></i>
                <img src="" id="img" alt=".">
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nome" placeholder="nome">
                <input type="file" name="capa" placeholder="capa" id="file">
                <input type="text" name="trailer" placeholder="trailer">
                <input type="text" name="link" placeholder="Link Do FIlme">
                <select id="opcoes" name="select">
                    <option value="categoria">Categoria</option>
		            <option value="series">Séries</option>
		            <option value="filmes">Filmes</option>
	            </select>
                <select id="opcoes" name="app">
                    <option value="app">App?</option>
                    <option value="netflix">Netflix</option>
		            <option value="prime">Prime Video</option>
		            <option value="disney">Disney+</option>
                    <option value="hbo">HBO Max</option>
	            </select>
                <span id="dodia">
                  <input type="checkbox" name="dodia" id="dodia1">
                  <label for="dodia1">     Do Dia ?</label>
                </span>
                <input type="text" name="descricao" placeholder="descrição">
                <input type="submit" value="Upload" name="submit">
            </form>
        </div>
    </section>
    <script src="js/upload.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>