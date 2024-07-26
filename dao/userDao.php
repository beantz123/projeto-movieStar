<?php 

    require_once("models/User.php");
    require_once("models/message.php");

    class UserDAO implements UserDAOInterface {
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        //criando um usuario com base no modelo da class user
        public function buildUser($data){
            $user = new User();

            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->image = $data['image'];
            $user->bio = $data['bio'];
            $user->token = $data['token'];

            return $user;
            
        }

        //inserir o usuario no banco
        public function create(User $user, $authUser = false){
            $stmt = $this->conn->prepare("INSERT INTO users(
                name, lastname, email, password, token
            )   Values (
                :name, :lastname, :email, :password, :token
            )");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            //autenticar o usuario, caso auth seja true
            if($authUser) {
                $this->setTokenToSession($user->token);
            }
        }

        public function update(User $user, $redirect = true){
            $stmt = $this->conn->prepare("UPDATE users SET
                name = :name,
                lastname = :lastname,
                email = :email,
                image = :image,
                bio = :bio,
                token = :token
                WHERE id = :id
            ");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect) {
                //redirecionar para o perfil do usuario
                $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
            }

        }
        
        /* se vc chamar a funcao verifyToken sem passar um parametro o protected
        vai continuar sendo false */
        //por aqui vai dizer se o usuario ta autenticado e se ele pode ou nao acessar algumas coisas
        public function verifyToken($protected = false){

            if(!empty($_SESSION["token"])) {

                //pega o token da session
                $token = $_SESSION["token"];

                //verificar se esse usuario existe
                $user = $this->findByToken($token);

                if($user) {
                    return $user;

                //o protected true vai exibir a mensagem abaixo e redirecionar
                //vai ta protegendo uma pagina
                } else if($protected) {
                
                    //redirecionar usuario nao autenticado
                    $this->message->setMessage("Faça autenticação para acessar essa pagina", "error", "index.php");
        
                }

            //aqui ta checando se ela é protect pq nao ta sendo passado nada na session
            } else if($protected) {
                
                //redirecionar para o perfil do usuario
                $this->message->setMessage("Faça autenticação para acessar essa pagina", "error", "index.php");
    
            }

        }
        
        public function setTokenToSession($token, $redirect = true){

            //salvar o token na session
            $_SESSION["token"] = $token;

            if($redirect) {
                //redirecionar para o perfil do usuario
                $this->message->setMessage("Seja bem-vindo", "success", "editprofile.php");
            }

        }

        /* processo de fazer login */
        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);
      
            if($user) {
      
              // Checar se as senhas batem
              if(password_verify($password, $user->password)) {
 
                //gerar token e inserir na session
                $token = $user->generateToken();

                //inserir token na session
                $this->setTokenToSession($token, false);

                //atualizar token no usuário
                $user->token = $token;

                //atualizar o user
                $this->update($user, false);

                return true;

              } else {

                return false;

              }
      
            } else {
            
              return false;
      
            }
      
        }
    
        public function findByEmail($email){

            if($email != "") {

                /*aqui ele ta verificando no banco se ja existe um usuario cadastrado com o 
                email q foi passado como parametro da função*/
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                /*aqui vai ser verificado se foi encontrado algo no banco
                essa função vai verificar se teve um retorno de linhas*/
                if($stmt->rowCount() > 0) {

                    /*aqui se caso ele encontrar algo vai pegar o resultado e retornar
                    pra função buildUser onde vai ser criado um obj e depois retornado */
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findById($id){

            if($id != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else { 
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findByToken($token){

            if($token != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;
                    
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        public function destroyToken() {
            //remove o token da sessao
            $_SESSION["token"] = "";

            $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");
        }
        
        public function changePassword(User $user){

            $stmt = $this->conn->prepare("UPDATE users SET 
                password = :password
                WHERE id = :id");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
        }

    }