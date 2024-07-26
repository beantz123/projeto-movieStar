<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/message.php");
    require_once("dao/userDao.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    //essa função ja pega os dados de input livres de qualquer dado malicioso
    $type = filter_input(INPUT_POST, "type");

    //variaçoes dependendo do tipo de type
    if($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        //verificação se os dados minimos foram enviados
        if($name && $lastname && $email && $password) {

            //verificação/autenticação de senha e confirm senha
            if($password === $confirmpassword){
                
                //verificar se o email ja esta cadastrado
                if($userDao->findByEmail($email) === false) {

                    /* apos ter sido feitas todas essas validações, agora
                    vai ser criado um obj de usuario */
                    $user = new User();

                    //criação de token e senha
                    //vai gerar caracter de string aleatorios
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    //dando a autenticação
                    $authUser = true;

                    /* aqui vai mandar o objeto criado 
                    pro banco */
                    $userDao->create($user, $authUser);

                } else {

                    $message->setMessage("Usuario ja cadastrado, tente outro email.", "error", "back");
                }

            } else {
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }

        } else {

            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
            
        }

    } else if ($type === "login"){

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if($userDao->authenticateUser($email, $password)) {

           $message->setMessage("Seja bem-vindo", "success", "editprofile.php");
        
        } else {

            $message->setMessage("Usuario e/ou senha incorretos.", "error", "back");
        
        }

    } else {

        $message->setMessage("Informações invalidas.", "error", "index.php");

    }