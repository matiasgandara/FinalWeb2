<?php
require_once "./models/userModel.php";
require_once "./helpers/loginHelper.php";
require_once "./views/userView.php";

class UserController {

	function __construct(){
        $this->model = new UserModel();
        $this->authHelper = new AuthHelper();
        $this->view = new userView();
    }

    public function IniciarSesion(){
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $username = $this->model->GetPassword($user);

        if (!empty($username) && password_verify($pass, $username->clave)){
            $this->authHelper->login($username);
            header('Location: logged');
        }else{
            header("Location: " . BASE_URL);
        }
       // header("Location: " . BASE_URL);
    }

    public function logout() {
        $this->authHelper->logout();
        header('Location: ' . BASE_URL);
    }

    public function registrar(){
        $this->view->displayRegistro();
    }

    public function registro(){

        $user = $_POST['user'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];

        if(!empty($user) && $pass1 == $pass2){
            $clave = password_hash($pass1, PASSWORD_DEFAULT);
            $this->model->registro($user, $clave);
            $username = $this->model->GetPassword($user);
            $this->authHelper->login($username);
            header('Location: ' . BASE_URL);
        }else{
            header('Location: ' . BASE_URL);
        }
    }

    public function getUsuarios(){
        if($this->authHelper->checkAdmin()){
            $user = $this->authHelper->getLoggedUserName();
            $usuarios = $this->model->getUsuarios();
            $this->view->DisplayUsuarios($usuarios, $user);
        }else{
            header('Location: ' . BASE_URL);
        }
    }

    public function darAdmin($params = NULL){
        $id = $params[':ID'];
        $valor = 1;
        if($this->authHelper->checkAdmin()){
            $this->model->editarAdmin($id, $valor);
            header('Location: ' . USUARIOS);
        }
    }

    public function quitarAdmin($params = NULL){
        $id = $params[':ID'];
        $valor = 0;
        if($this->authHelper->checkAdmin()){
            $this->model->editarAdmin($id, $valor);
            header('Location: ' . USUARIOS);
        }
    }

    public function borrarUser($params = NULL){
        $id = $params[':ID'];
        if($this->authHelper->checkAdmin()){
            $this->model->eliminarUser($id);
            header('Location: ' . USUARIOS);
        }
    }
}