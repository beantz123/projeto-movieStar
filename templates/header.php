<?php 
    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");
    require_once("dao/userDao.php");

    $message = new Message($BASE_URL);

    $flashMessage = $message->getMessage();

    //aqui quando recarregar a pagina vai apagar a msg
    if(!empty($flashMessage["msg"])){
        $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);

    //verificando se o usuario q ta acessando ja ta logado e se estiver vai retornar um usuario
    //o false é pra dizer que todos podem acessar o cabeçalho/header
    //se quisesse proteger uma pagina, colocaria true
    $userData = $userDao->verifyToken(false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>movies star</title>
    <!-- na parte de navegação -->
    <link rel="short icon" href="<?= $BASE_URL ?>img/moviestar.ico">
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?= $BASE_URL ?>" class="navbar-brand">
                <img src="<?= $BASE_URL ?>img/logo.svg" alt="moviestar" id="logo">
                <span id="moviestar-title">MovieStar</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <!-- fazendo as margens pelo bootstrap-->
            <!-- parte de fazer a pesquisa dos filmes -->
            <form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar Filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <!-- parte da nav para se cadastrar e entrar -->
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData): ?>
                        <li class=nav-item>
                            <a href="<?= $BASE_URL ?>newmovie.php" class="nav-link">
                                <i class="far fa-plus-square"></i> Incluir Filme
                            </a>
                        </li>
                        <li class=nav-item>
                            <a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus Filme</a>
                        </li>
                        <li class=nav-item>
                            <a href="<?= $BASE_URL ?>editprofile.php" class="nav-link">
                                <?= $userData->name ?>
                            </a>
                        </li>
                        <li class=nav-item>
                            <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class=nav-item>
                            <a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <?php if(!empty($flashMessage["msg"])): ?>
        <div class="msg-container">
            <p class="msg <?= $flashMessage["type"] ?>"><?= $flashMessage["msg"] ?></p>
        </div>
    <?php  endif; ?>