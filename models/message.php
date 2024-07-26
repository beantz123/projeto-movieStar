<?php 

    class Message {

        private $url;

        public function __construct($url) {
            $this->url = $url;
        }

        //parametros de msg, o tipo dela e se vai redirecionar ou nao
        public function setMessage($msg, $type, $redirect = "index.php") {

            //inserindoo a mensagem na variavel session
            $_SESSION["msg"] = $msg;
            $_SESSION["type"] = $type;

            /*INSERINDO UMA MSG E REDIRECIONANDO PRA UMA PAGINA*/

            /* aqui ele vai verificar o que tem em redirect, back significa pra voltar uma pagina 
            e http_referer quer dizer a ultima pagina/url que o usuario acessou ou seja a mesma coisa */
            if($redirect != "back") {
                header("Location: " . $redirect);
            } else {
                header("Location: " .  $_SERVER["HTTP_REFERER"]);
            }
        }

        /*o primeiro metodo insere uma informação, o segundo pega ela e 
        o exibe no header atraves da variavel $flashMensagem*/
        
        public function getMessage() {

            if(!empty($_SESSION["msg"])) {
                return [
                    "msg" => $_SESSION["msg"],
                    "type" => $_SESSION["type"]
                ];
            } else {
                return false;
            }

        }

        public function clearMessage() {
                $_SESSION["msg"] = "";
                $_SESSION["type"] = "";
        }
    }
