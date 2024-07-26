<?php 

    require_once("templates/header.php");
    
    //verificando se tem usuario logado
    if($userDao) {
        $userDao->destroyToken();
    } 