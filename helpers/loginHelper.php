<?php

class AuthHelper{

    function __construct() {}


        public function login($user) {
            // INICIO LA SESSION Y LOGUEO AL USUARIO
            session_start();
            $_SESSION['ID_USER'] = $user->id;
            $_SESSION['USERNAME'] = $user->nombre_usuario;
            $_SESSION['ADMINISTRADOR'] = $user->administrador;
        }
    
        public function logout() {
            session_start();
            session_destroy();
        }

        public function checkAdmin(){
        
            if($this->checkLoggedIn()){
                return ($_SESSION['ADMINISTRADOR']);
            }else{
                return false;
            }           
        }
    
        public function checkLoggedIn() {
            if (!isset($_SESSION)){
            session_start();
            }
            if (!isset($_SESSION['ID_USER'])) {
                return false;
            }else{
                return true;
            }       
        }
    
        public function getLoggedUserName() {
            if (session_status() != PHP_SESSION_ACTIVE)
                session_start();
            return $_SESSION['USERNAME'];
        }
}
  