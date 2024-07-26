<?php 

    class Movie {

        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $users_id;

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }
    }

    interface MovieDAOInterface {

        //criar um obj de filme
        public function buildMovie($data);
        //vai encontrar todos os filmes do banco de dados
        public function findAll();
        //pegar todos os filmes em ordem decrescente
        public function getLatesMovies();
        //pegar os filmes por uma determinada categoria
        public function getMoviesByCategory($category);
        //pegar filmes de um usuario especifico
        public function getMoviesByUserId($id);
        //encontrar um filme por id
        public function findById($id);
        //encontrar um filme por um titulo especifico
        public function findByTitle($title);
        //esse Movie em verde se refere ao models
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);
        
    }