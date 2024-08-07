<?php 
    require_once("templates/header.php");
    //verifica se usuario esta autenticado
    require_once("dao/userDao.php");
    require_once("dao/movieDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDAO($conn, $BASE_URL);

    $movieDao = new MovieDAO($conn, $BASE_URL);

    //receber o id do usuario
    $id = filter_input(INPUT_GET, "id");

    /* verificação pra se caso estiver sem id mas se tiver um usuario logado */
    if(empty($id)) {

        if(!empty($userData)) {

            $id = $userData->id;

        } else {

            $message->SetMessage("O usuário não foi encontrado", "error", "index.php");

        }

    } else {

        $userData = $userDao->findById($id);

        if(!$userData) {

            //se nao encontrar usuario
            $message->SetMessage("O usuário não foi encontrado", "error", "index.php");

        } 

    }

    $fullName = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }

    //filmes que o usuario adicionou
    $userMovies = $movieDao->getMoviesByUserId($id);

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12" class="about-container">
                    <h1 class="page-title"><?= $fullName ?></h1>
                    <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if(!empty($userData->bio)): ?>
                        <p class="profile-description"><?= $userData->bio ?></p>
                    <?php else: ?>
                        <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                    <div class="movies-container">
                        <?php foreach($userMovies as $movie): ?>
                            <?php require("templates/movie-card.php"); ?>
                        <?php endforeach; ?>
                        <?php if(count($userMovies) === 0): ?>
                            <p class="empty-list">O usuário ainda não enviou filmes.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
    require_once("templates/footer.php");
?>