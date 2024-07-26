<?php 

    class User {

        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $bio;
        public $token;

        //função pra pegar um usuario e retorna o nome e o sobrenome do mesmo
        public function getFullName($user) {
            return $user->name . " " . $user->lastname;
        }

        public function generateToken() {
            /*a random vai retornar uma string aleatoria de 50 caracter 
            e a bin vai receber e tornar essa string mais complexa*/
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($password) {
            /* a de baixo vai criar uma hash para senhas, esse segundo
            parametro ainda determina que tipo de hash vai ser criada */
            return password_hash($password, PASSWORD_DEFAULT);
        }

        /* uma forma de evitar que uma imagem nao va ser 
        substituida por outro usuario*/
        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }
    }

    interface UserDAOinterface {

        //METODOS A SEREM ULTILIZADO AO LONGO DO NOSSO SISTEMA

        //isso aqui vai construir um objeto
        public function buildUser($data);
        //criar um usuario e dar a ele a autenticação
        public function create(User $User, $authUser = false);
        //para poder atualizar o usuario no sistema
        public function update(User $user, $redirect = true);
        /*algumas rotas vao estar protegidas ao longo da navegação
        direcionando o usuario para algumas rotas caso ele esteja ou nao logado*/
        public function verifyToken($protected = false);
        /*vai fazer o login, redirect quer dizer q vai redirecionar o usuario pra uma pagina especifica*/
        public function setTokenToSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        //vou poder encontrar um usuario por email
        public function findByEmail($email);
        public function findById($id);
        //receber um token e encontrar um usuario no sistema pelo token dele
        public function findByToken($token);
        public function destroyToken();
        //vai ser usado para trocar a senha
        public function changePassword(User $user);
    }