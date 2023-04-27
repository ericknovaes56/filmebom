<?php
    
    require_once '../assets/db/db.php';
    session_start();
    if (isset($_SESSION['logado'])){
        header('location:../');
    };

    $sql = "SELECT * FROM conteudo WHERE dodia = 'on'";
    $result = mysqli_query($connect , $sql);
    $dodia = mysqli_fetch_array($result);
    $dodia['capa'] = '../' . $dodia['capa'];
    if(isset($_POST['criar'])){
        $erros = array();
        $nome = mysqli_escape_string($connect , $_POST['nome']);
        $email = mysqli_escape_string($connect , $_POST['email']);
        $senha = mysqli_escape_string($connect , $_POST['senha']);
        if (empty($nome) or empty($email) or empty($senha)){
            $erros[] = "Campos Vazios !";
        }else{
            $crypy = password_hash($senha,  PASSWORD_BCRYPT);
            $sql = "SELECT email FROM user WHERE email = '$email'";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                $erros[] = "Erro: Email Já existe";
            }else{
                $sql = "INSERT INTO user (nome,email,senha) VALUES ('$nome','$email','$crypy')";
                $result = mysqli_query($connect, $sql);
                $erros[] = "Sua Conta Foi Criada";
            }
        }
    };

    if(isset($_POST['entrar'])){
        $erros = array();
        $email = mysqli_escape_string($connect , $_POST['email']);
        $senha = mysqli_escape_string($connect , $_POST['senha']);
        if (empty($email) or empty($senha)){
            $erros[] = "Login ou Senha Vazio !";
        }else{
            $sql = "SELECT email FROM user WHERE email = '$email'";
            $result = mysqli_query($connect, $sql);
            $dados = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) > 0){
                $sql = "SELECT * FROM user WHERE email = '$email'";
                $result = mysqli_query($connect , $sql);
                $dados = mysqli_fetch_array($result);
                $senha = password_verify($senha, $dados['senha'] );
                if ($senha == 1 ){
                    $senha = $dados['senha'];
                    $sql = "SELECT * FROM user WHERE email = '$email' AND senha = '$senha'";
                    $result = mysqli_query($connect,$sql);
                    if (mysqli_num_rows($result) == 1){
                        $dados = mysqli_fetch_array($result);
                        $_SESSION['logado'] = true;
                        $_SESSION['id_user'] = $dados['id'];
                        $result = mysqli_query($connect , $sql);
                        $dados = mysqli_fetch_array($result);
                        header('location:../');
                    }else{
                        $erros[] = "Email ou senha incorretos";
                    };
                }else{
                    $erros[] = "Senha Incorreta";
                }
            }else{
                $erros[] = "Email Não Cadastrado";
            };
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
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <section class="login" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $dodia['capa']?>');">
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
        <div class="top">
            <a href="../index.php"><input type="button" value="Voltar"></a>
        </div>
        <div class="all">
            <div class="forms">
                <form method="POST" class="entrar">
                    <div class="cima">
                        <span>#Bem Vindo</span>
                        <h1>Fazer Login</h1>
                        <p>Aviso 🚨: tome cuidado com suas senhas 🔒 e sempre utilize senhas diferentes 🔢 para cada site que acessar. É sempre importante se precaver 🧐."</p>
                    </div>
                    <input type="email" name="email" placeholder="email" class="inp">
                    <input type="password" name="senha" placeholder="password" class="inp">
                    <div class="fuc">
                        <input type="submit" value="Entrar" class="n1" name="entrar">
                        <input type="button" value="Criar Conta" class="n2" id="btn1">
                    </div>
                    <p>Obrigado por fazer parte desta comunidade que adora filmes. Esperamos que goste e fique feliz com a plataforma.</p>
                </form>
                <form method="POST" class="criar">
                    <div class="cima">
                        <span>#Bem Vindo</span>
                        <h1>Criar Conta</h1>
                        <p>Aviso 🚨: tome cuidado com suas senhas 🔒 e sempre utilize senhas diferentes 🔢 para cada site que acessar. É sempre importante se precaver 🧐."</p>
                    </div>
                    <input type="text" name="nome" placeholder="usuario" class="inp">
                    <input type="email" name="email" placeholder="email" class="inp">
                    <input type="password" name="senha" placeholder="password" class="inp">
                    <div class="fuc">
                        <input type="submit" name="criar" value="Criar Conta" class="n1">
                        <input type="button" value="Fazer Login" class="n2" id="btn2">
                    </div>
                </form>
            </div>
            <img src="../assets/img/logo.png" id="logo">
        </div>
    </section>
    <script src="js/login.js"></script>
</body>
</html>