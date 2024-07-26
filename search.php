<?php 
    require_once("templates/header.php");

    require_once("dao/movieDao.php");

    $movieDao = new MovieDAO($conn, $BASE_URL);

    //resgatar busca do usuário
    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDao->findByTitle($q);

?>

<div id="main-container" class="fluid">
    <h2 class="section-title" id="search-title">Você está em busca por: <span id="search-result"><?= $q ?></span></h2>
    <p class="section-description">Resultado de busca retornados com base na sua pesquisa.</p>
    <div class="movies-container">
        <?php foreach($movies as $movie): ?>
            <?php require("templates/movie-card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($movies) === 0): ?>
            <p class="empty-list">Não há filmes para está busca, <a href="<?= $BASE_URL ?>" class="back-link">Voltar</a></p>
        <?php endif; ?>
    </div>
</div>
<?php 
    require_once("templates/footer.php");
?>