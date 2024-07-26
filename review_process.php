<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/message.php");
    require_once("models/Review.php");
    require_once("dao/userDao.php");
    require_once("dao/movieDao.php");
    require_once("dao/ReviewDao.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDao($conn, $BASE_URL);

    //essa função ja pega os dados de input livres de qualquer dado malicioso
    $type = filter_input(INPUT_POST, "type");

    $userData = $userDao->verifyToken();

    //variaçoes dependendo do tipo de type
    if($type === "create") {

        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");
        $movies_id = filter_input(INPUT_POST, "movies_id");
        $users_id = $userData->id;

        $reviewObject = new Review();

        $movieData = $movieDao->findById($movies_id);

        if($movieData) {

            if(!empty($rating) && !empty($review) && !empty($movies_id)) {

                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->movies_id = $movies_id;
                $reviewObject->users_id = $users_id;
                
                $reviewDao->create($reviewObject);

            } else {

                $message->setMessage("Precisa inserir a nota e comentário", "error", "back");

            } 

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");

        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }
