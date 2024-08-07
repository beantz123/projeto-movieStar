<?php 
    require_once("templates/header.php");
?>
    <div id="main-container" class="fluid">
        <!-- dizendo que abaixo atraves do boodstrap que vai existir
        uma div contendo 12 colunas -->
        <div class="col-md-12">
            <!-- abaixo uma div de class row quer dizer q os itens
            nela vão ficar um do lado do outro -->
            <div class="row" id="auth.row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action= "<?= $BASE_URL ?>auth_process.php" method="POST">
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Digite sua senha">
                        </div>
                        <br>
                        <input type="submit" class="card-btn" value="Entrar">
                    </form>
                </div>
                <!-- essa classe definindo q a div vai possuir quatro colunas -->
                <div class="col-md-4" id="register-container">
                    <h2>Criar Contato</h2>
                    <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                        <!-- um input anonimo q la no back vai mostrar só o valor
                        que vai dizer o que ta sendo feito e enviado nesse form
                        se guia nos arquivos pelos valores do input -->
                        <input type="hidden" name="type" value="register">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirme sua senha:</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme sua senha">
                        </div>
                        <br>
                        <input type="submit" class="card-btn" value="Registrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php 
    require_once("templates/footer.php");
?>