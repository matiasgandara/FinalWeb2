<?php

require_once "./model/EncuestaModel.php";
require_once ".view/EncuestaView.php";
require_once "./helpers/loginHelper.php";


class EncuestaController{
    private $model;
    private $view;
    private $helper;

    function __construct(){
        $this->model = new EncuestaModel();
        $this->view = new EncuestaView();
        $this->helper = new AuthHelper();
    }

    public function nuevaEncuesta(){
        if($this->helper->checkAdmin()){
            $titulo = $_POST['titulo'];
            if (!$this->model->getEncuestaTitulo($titulo)){
                $id = $this->model->nuevaEncuesta($_POST['titulo'], $_POST['descripcion'], $_POST['multiple']);
                header("Location: ". ENCUESTA);
                $multiple = $_POST['multiple'];
                if (!$multiple){
                    $this->model->nuevaOpcion($id,'SI');
                    $this->model->nuevaOpcion($id,'NO');
                    header("Location: ". OPCION);
                    $this->view->displayNuevaEncuestaSimple();
                }
                $this->view->displayNuevaEncuesta();
            }
            $this->view->showError("La encuesta con ese titulo ya existe");
        }
        $this->view->showError("usuario sin permiso");
    }

    public function agregaOpcion(){
        if($this->helper->checkAdmin()){
            $encuesta = $this->model->getEncuesta($_POST['id_necuesta']);
            if(!$encuesta->multiple){
                $this->model->nuevaOpcion($_POST['id_necuesta'], $_POST['texto']);
                header("Location: ". OPCION);
            }
            $this->view->showError("esta encuesta es simple, no acepta mas opciones");
        }
        $this->view->showError("usuario sin permiso");
    }

    public function mostrarRespuestas($params = null){
        $id = $params[':ID'];
        if($this->helper->checkAdmin()){
            $opciones = $this->model->getOpciones($id);
            if($opciones){
                $respuestas = [];
                foreach ($opciones as $opcion){
                    $cantidad = $this->getRespondidas($id,$opcion->id);
                    $respuestas->array_push([this->getEncuesta($id), $opcion, $cantidad]);
                }
                $this->view->mostrarRespuestas($respuestas, $this->model->getTotalRespuestas($id));

            }
            $this->view->showError("esta encuesta no posee respuestas");
        }
        $this->view->showError("usuario sin permiso");
    }

    public function votarSimple($params = null){
        $id = $params[':ID'];
        if($this->helper->checkLoggedIn()){
            $respuesta = $this->model->getRespuesta($id,$_POST['id_usuario']); 
            if (!$respuesta){
                $this->model->nuevaRespuesta($id,$_POST['id_opcion'],$_POST['id_usuario']);
                header("Location: ". RESPUSTA);
                this->view->showRespondido();
            }
        }
        $this->view->showError("usuario sin no logeado");
    }

    public function votarMultiple($params = null){
        $id = $params[':ID'];
        if($this->helper->checkLoggedIn()){
            $respondida = $this->model->getRespuesta($id,$_POST['id_opcion'],$_POST['id_usuario']); 
            if (!$respondida){
                $this->model->nuevaRespuesta($id,$_POST['id_opcion'],$_POST['id_usuario']);
                header("Location: ". RESPUESTA);
                this->view->showRespondido();
            }
        }
        $this->view->showError("usuario sin no logeado");
    }

}