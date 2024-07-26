<?php 
    require_once("templates/header.php");
    //verifica se usuario esta autenticado
    require_once("dao/userDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDAO($conn, $BASE_URL);

    /* por ser uma pagina q precisa da autenticação para acessar
    o verifyToken recebe um true para proteger a pagina, ou seja
    se o usuario nao estiver autenticado ele nao entra */
    $userData = $userDao->verifyToken(true);

?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Filme</h1>
            <p class="page-description">Adicione sua critica e compartilhe com outros usuarios</p>
            <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title">Titulo:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o titulo do seu filme">
                </div>
                
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image">
                </div>
                
                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme">
                </div>
                
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Drama">Drama</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Fantasia /Ficção">Fantasia /Ficção</option>
                        <option value="Romance">Romance</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
                </div>
                
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea  class="form-control" name="description" id="description" rows="5" placeholder="Descreva o filme..."></textarea>
                </div>
                
                <input type="submit" class="card-btn" value="Adicionar Filme">
            </form>
        </div>
    </div>
<?php 
    require_once("templates/footer.php");
?>