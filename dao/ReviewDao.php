<?php

    require_once("models/Review.php");
    require_once("models/message.php");

    require_once("dao/userDao.php");

    class ReviewDao implements ReviewDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data) {

            $reviewObject = new Review();

            $reviewObject->id = $data["id"];
            $reviewObject->rating = $data["rating"];
            $reviewObject->review = $data["review"];
            $reviewObject->users_id = $data["users_id"];
            $reviewObject->movies_id = $data["movies_id"];

            return $reviewObject;

        }

        public function create(Review $review){

            $stmt = $this->conn->prepare("INSERT INTO reviews (
                rating, review, movies_id, users_id 
            ) VALUES (
                :rating, :review, :movies_id, :users_id
            )");

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":movies_id", $review->movies_id);
            $stmt->bindParam(":users_id", $review->users_id);

            $stmt->execute();

            //exibindo mensagem e redirecionando
            $this->message->setMessage("Crítica adicionada com sucesso!", "success", "index.php");

        }

        public function getMoviesReview($id){

            $reviews = [];

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $ReviewsData = $stmt->fetchAll();

                $userDao = new UserDao($this->conn, $this->url);

                foreach($ReviewsData as $review) {

                    $reviewObject = $this->buildReview($review);

                    //chamar dados do usuário
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }

            } 

            return $reviews;

        }

        //metodo para verificar se um usuario ja deu review em um filme
        public function hasAlreadyReviewed($id, $userId){
            
            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id AND 
            users_id = :users_id");

            $stmt->bindParam(":movies_id", $id);
            $stmt->bindParam(":users_id", $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        //metodo para pegar as notas do filme especifico e calcular a media deles
        public function getRatings($id){

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $rating = 0;

                $reviews = $stmt->fetchAll();

                //calculando a média
                foreach($reviews as $review) {
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);

            } else {

                $rating = "Não avaliado";

            }

            return $rating;

        }

    }