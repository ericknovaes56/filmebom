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
    if(isset($_POST['foto'])){
        if(!empty($_FILES['file'])){
            $formatosPermitidos= array("png", "jpeg", "jpg", "gif");
            $extensao=pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if(in_array($extensao, $formatosPermitidos)){
                $varid = $dadosall['id'];
                $pasta="assets/img/users/";
                $pasta2="../assets/img/users";
                $move="../assets/img/users/";
                if (!is_dir($pasta2)){
                    mkdir($pasta2, 0777, true);
                }
                $temporario= $_FILES['file']['tmp_name'];
                $novoNome=uniqid().".$extensao";
                if(move_uploaded_file($temporario, $move. $novoNome)){
                    $mensagem[]="Upload feito com sucesso!";
                    $salvarnobanco = $pasta. $novoNome;
                    $sql = "UPDATE user SET img='$salvarnobanco' WHERE id=".$dadosall['id'];
                    $result = mysqli_query($connect,$sql);
                    header('location:perfil.php');
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
</head>
<body>
<nav class="menu">
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
                            <li><a href="upload.php">Upload</a></li>
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
        <div class="sidebar">
            <div class="topp">
                <a href="../">
                    <input type="button" value="Inicio" class="btn1 activado">
                </a>
                <a href="perfil.php?locate=perfil">
                    <input type="button" value="Perfil" class="btn2">
                </a>
                <a href="perfil.php?locate=favoritos">
                    <input type="button" value="favoritos" class="btn2">
                </a>
            </div>
            <div class="bottom">
                <a href="../assets/db/sair.php">
                    <input type="button" value="Sair Da Conta" class="btn3">
                </a>
                <a href="../assets/db/destroy.php">
                    <input type="button" value="Deletar Conta" class="btn4" >
                </a>
            </div>
        </div>
        <div class="content">
            <div class="user_perfil">
                <a href="subpage/update.php" class="aperfil">
                    <span id="edit">
                        <i class='bx bx-message-square-edit'></i>
                        <span id="title">EDITAR</span>
                    </span>
                </a>
                <label for="photo">
                    <div class="user_photo">
                        <form method="post" enctype="multipart/form-data" class="dont">
                            <input type="file" id="photo" name="file">
                            <input type="submit" name="foto" id="upload">
                        </form>
                        <div class="img">
                            <i class='bx bxs-camera' id="icon"></i>
                            <img src='<?php echo $dadosall['img']?>' id="foto">
                        </div>
                        <span class="show">Modifique sua foto</span>
                    </div>
                </label>
                <div class="user_infos">
                    <span id="conta_type"><?php echo $dadosall['cargo']?></span>
                    <div class="name">
                        <h1><?php echo $dadosall['nome']?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/perfil.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>