<?php
    
    require_once '../../assets/db/db.php';
    session_start();
    if (!isset($_SESSION['logado'])){
        header('location:../../');
    };
    if (isset($_SESSION['logado'])){
        $id = $_SESSION['id_user'];
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = mysqli_query($connect , $sql);
        $dadosall = mysqli_fetch_array($result);
        $dadosall['img'] = '../../'. $dadosall['img'];
    };

    if (isset($_POST['bnome'])){
        $nome = mysqli_escape_string($connect , $_POST['nome']);
        if (!empty($nome)){
            $sql = "UPDATE user SET nome ='$nome' WHERE id =".$dadosall['id'];
            $result = mysqli_query($connect , $sql);
            header('location:update.php');

        };
    };
    if (isset($_POST['bemail'])){
        $email = mysqli_escape_string($connect , $_POST['email']);
        if (!empty($email)){
            $sql = "UPDATE user SET email ='$email' WHERE id =".$dadosall['id'];
            $result = mysqli_query($connect , $sql);
            header('location:update.php');

        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Login - FilmeBom</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/styles/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="css/style.css">
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
                            <li><a href="../../">Inicio</a></li>
                            <li><a href="../perfil.php?locate=perfil">Perfil</a></li>
                            <li><a href="../perfil.php?locate=favoritos">Favoritos</a></li>
                            <li><a href="../upload.php">Upload</a></li>
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
                            <li><a href="../../">Inicio</a></li>
                            <li><a href="../perfil.php?locate=perfil">Perfil</a></li>
                            <li><a href="../perfil.php?locate=favoritos">Favoritos</a></li>
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
        <div class="boxuser">
            <form method="post">
                <h2>Altere Seu Nome</h2>
                <input type="text" name="nome" placeholder="<?php echo $dadosall['nome']?>">
                <input type="submit" value="Alterar Nome" name="bnome" class="btn">
            </form>
            <form method="post">
                <h2>Altere Seu Email</h2>
                <input type="email" name="email" placeholder="<?php echo $dadosall['email']?>">
                <input type="submit" value="Alterar Email" name="bemail" class="btn">
            </form>
        </div>
    </section>
    <script src="js/perfil.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>