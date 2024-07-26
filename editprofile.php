<?php 
    require_once("templates/header.php");
    require_once("dao/userDao.php");
    require_once("models/User.php");

    $user = new User();

    $userDao = new UserDAO($conn, $BASE_URL);

    /* por ser uma pagina q precisa da autenticação para acessar
    o verifyToken recebe um true para proteger a pagina, ou seja
    se o usuario nao estiver autenticado ele nao entra */
    $userData = $userDao->verifyToken(true);

    /*recebendo os dados de um usuario pelo token dele
    e pegando apenas o nome*/

    $fullName = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }

?>
    <div id="main-container" class="container-fluid edit-profile-page">
        <div class="col-md-12">
            <!-- para envio de imagem enctype é obrigatorio-->
            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden"  name="type" value="update">
                <div class="row">
                    <!-- a div de baixo ta dizendo que do espaço de 12 colunas, ela
                    vai ocupar 4-->
                    <div class="col-md-4">
                        <h1><?= $fullName ?></h1>
                        <p class="page-description">Altere seus dados no formulário abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome"
                            value="<?= $userData->name ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu sobrenome"
                            value="<?= $userData->lastname ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite seu email"
                            value="<?= $userData->email ?>">
                        </div>
                        <br>
                        <input type="submit" class="card-btn" value="Alterar">
                    </div>
                    <!-- foto -->
                    <div class="col-md-4">
                        <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="bio">Sobre você:</label>
                            <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="conte o que você é, o que faz, onde trabalha e etc"><?= $userData->bio ?></textarea>
                        </div>            
                    </div>
                </div>
            </form>
            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Alterar senha:</h2>
                    <p class="page-description">Digite sua nova senha e confirme, para alterar sua senha:</p>
                    <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                        <input type="hidden" name="type" value="changepassword">
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmação de senha:</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua nova senha">
                        </div>
                        <br>
                        <input type="submit" class="card-btn" value="Alterar senha">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php 
    require_once("templates/footer.php");
?>