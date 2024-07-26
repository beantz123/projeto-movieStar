<?php 

    //pra poder usar a $_SESSION precisa iniciar ela com esse comando
    session_start();

    $BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"] ."?") . "/";
    