<?php 
    require_once("templates/header.php");

    require_once("dao/movieDao.php");

    $movieDao = new MovieDAO($conn, $BASE_URL);

    $latesMovies = $movieDao->getLatesMovies();

    $actionMovies = $movieDao->getMoviesByCategory("Ação");

    $comedyMovies = $movieDao->getMoviesByCategory("Comédia");

    $fantasyFicao = $movieDao->getMoviesByCategory("Fantasia /Ficção");

    $romance = $movieDao->getMoviesByCategory("Romance");
    
?>
    <div id="main-container" class="fluid">
        <h2 class="section-title">Filmes Novos</h2>
        <p class="section-description">Veja as críticas dos últimos filmes adicionados no MovieStar</p>
        <div class="movies-container">
            <?php foreach($latesMovies as $movie): ?>
                <?php require("templates/movie-card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($latesMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados</p>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação</p>
        <div class="movies-container">
            <?php foreach($actionMovies as $movie): ?>
                <?php require("templates/movie-card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de ação cadastrados</p>
            <?php endif; ?>
            
        </div>
        <h2 class="section-title">Comedia</h2>
        <p class="section-description">Veja os melhores filmes de comédia</p>
        <div class="movies-container">
            <?php foreach($comedyMovies as $movie): ?>
                <?php require("templates/movie-card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($comedyMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de comedia cadastrados</p>
            <?php endif; ?>
        
        </div>
        <h2 class="section-title">Fantasia e Ficção</h2>
        <p class="section-description">Veja os melhores filmes de Fantasia e Ficção</p>
        <div class="movies-container">
            <?php foreach($fantasyFicao as $movie): ?>
                <?php require("templates/movie-card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($fantasyFicao) === 0): ?>
                <p class="empty-list">Ainda não há filmes de fantasia e ficção cadastrados</p>
            <?php endif; ?>
            
        </div>
        <h2 class="section-title">Romance</h2>
        <p class="section-description">Veja os melhores filmes de Romance</p>
        <div class="movies-container">
            <?php foreach($romance as $movie): ?>
                <?php require("templates/movie-card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($romance) === 0): ?>
                <p class="empty-list">Ainda não há filmes de romance cadastrados</p>
            <?php endif; ?>
            
        </div>
    </div>
<?php 
    require_once("templates/footer.php");
?>