<?php
 require_once 'assets/db/db.php';
 session_start();


 if (isset($_SESSION['logado'])){
    $id = $_SESSION['id_user'];
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($connect , $sql);
    $dadosall = mysqli_fetch_array($result);
};

$sql = "SELECT * FROM conteudo WHERE dodia = 'on'";
$result = mysqli_query($connect , $sql);
$dodia = mysqli_fetch_array($result);

$sql = "SELECT * FROM conteudo";
$result = mysqli_query($connect , $sql);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmeBom</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/media.css">
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
                            <li><a href="page/perfil.php?locate=perfil">Perfil</a></li>
                            <li><a href="page/perfil.php?locate=favoritos">Favoritos</a></li>
                            <li><a href="page/upload.php">Upload</a></li>
                            <li><a href="#">Pagina de Controle</a></li>
                        </ul>
                        <div class="sair">
                            <a href="assets/db/sair.php">Sair Da Conta</a>
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
                            <li><a href="page/perfil.php?locate=perfil">Perfil</a></li>
                            <li><a href="page/perfil.php?locate=favoritos">Favoritos</a></li>
                        </ul>
                        <div class="sair">
                            <a href="assets/db/sair.php">Sair Da Conta</a>
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

    <header style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $dodia['capa']?>');">
        <div class="content anime">
            <span>#Do Dia</span>
            <span class="streaming">
                <img src="assets/img/stream/<?php echo $dodia['stream'];?>.png" class="logo">
                <?php echo $dodia['stream'];?>
            </span>
            <h1><?php echo $dodia['nome']?></h1>
            <p><?php echo $dodia['descricao']?></p>
            <div class="buttons">
                <a target="_blank" href="<?php echo $dodia['link']?>"><input type="button" value="Assistir"></a>
                <a href="#mais"><input type="button" value="Ver Mais"></a>
            </div>
        </div>
    </header>
    <?php

        if (!isset($_SESSION['logado'])){
            echo '
            <main>
                <div class="content">
                    <div class="texts">
                        <div class="nine">
                            <span>#faça sua conta</span>
                            <h1>Conecte já</h1>
                            <p>Faça sua conta e desfrute ainda mais desta plataforma e comunidade. Não perca tempo e crie já a sua conta no site clicando abaixo.</p>
                            <div class="buttons">
                                <a href="#">
                                    <input type="button" value="Conectar-se" class="normal">
                                </a>
                                <a href="#mais"><input type="button" value="Ver Mais" class="normal"></a>
                            </div>
                        </div>
                    </div>
                    <div class="img">
                        <img src="assets/img/rei.png">
                    </div>
                </div>
            </main>
            ';
        }
    
    ?>

    <section class="conteudos" id="mais">
        <div class="content">
            <div class="cabe">
                <span>
                    #Tudo De Bom
                </span>
                <h1>Assista Os Melhores !</h1>
                <div class="buttons">
                    <input type="button" value="Geral" id="bgeral" class="categb active">
                    <input type="button" value="Filmes" id="bfilmes" class="categb">
                    <input type="button" value="Series" id="bserie" class="categb">
                </div>
            </div>
            <div class="grid">
                <?php 
                    $sql = "SELECT * FROM conteudo";
                    $result = mysqli_query($connect , $sql);
                    foreach ($result as $index => $content) {
                        $content['trailer'] = str_replace("watch?v=", "embed/", $content['trailer']);
                        echo '
                        <a href="'.$content['link'].'" id="'.$content['categoria'].'" target="_blank" class="f aparece">
                            <div class="n" title="'.$content['trailer'].'" style="background-image: url('.$content['capa'].');">
                                <div class="stream opav"><img src="assets/img/stream/'.$content['stream'].'.png" width="100%" height="100%"></div>
                                <div class="playv"><i class="bx bx-play"></i></div>
                                <iframe class="if" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                            <div class="name1">'.$content['nome'].'</div>
                         </a>
                        ';
                    }
                ?>
            </div>
        </div>
    </section>
    <footer>
        <div class="init_footer">
            <h2>FilmeBom</h2>
            <h2>© 2020 - 2022 FilmeBom</h2>
        </div>
        <div class="links_footer">
            <ul class="text_footer">
                <div>
                    <h1 class="title_footer">Sobre</h1>
                    <p>Se você é um amante de cinema e está sempre em busca de bons filmes para assistir, então o site que vamos apresentar pode ser uma excelente opção. O site em questão é conhecido por reunir uma grande variedade de filmes de diferentes gêneros, todos com uma coisa em comum: a qualidade.</p>
                </div>
            </ul>
            <ul class="coluna_footer">
                <h1 class="title_footer">Redes</h1>
                <li><a href="#" class="links_of_footer"><i class='bx bxl-instagram-alt' ></i>Instagram</a></li>
                <li><a href="#" class="links_of_footer"><i class='bx bxl-tiktok' ></i>TikTok</a></li>
            </ul>
            <ul class="coluna_footer">
                <h1 class="title_footer">Link</h1>
                <li><a href="#main" class="links_of_footer"><i class='bx bxs-home-alt-2'></i>Produto</a></li>
            </ul>
            <ul class="coluna_footer">
                <h1 class="title_footer">Contato</h1>
                <li><a href="https://wa.me/5587981300723?text=Quero%20O%20Pack%20De%20Slide" target="_blank" class="links_of_footer"><i class='bx bxl-whatsapp' ></i>Whatsapp</a></li>
            </ul>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>