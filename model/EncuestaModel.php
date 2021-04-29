<?php

class Encuesta extends PDO {

    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=encuesta;charset=utf8', 'root', '');
    }

    public function nuevaEncuesta($titulo, $descripcion, $multiple){
        $query = $this->db->prepare('INSER INTO Encuesta ("titulo", "descripcion", "multiple") VALUE (?,?,?)');
        $query->execute(array($titulo, $descripcion, $multiple));
    }

    public function nuevaOpcion($idEncuesta, $texto){
        $query = $this->db->prepare('INSER INTO Opcion ("id_encuesta", "texto") VALUE (?,?)');
        $query->execute(array($idEncuesta, $texto));
    }

    public function nuevaRespuesta($idEncuesta, $idOpcion, $idUser){
        $query = $this->db->prepare('INSER INTO Respuesta ("id_encuesta", "id_opcion", "id_usuario") VALUE (?,?,?)');
        $query->execute(array($idEncuesta, $idEncuesta, $idUser));
    }

    public function getEncuesta($id){
        $query = $this->db->prepare('SELECT * FROM Encuesta WHERE "id" = ?');
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getEncuestaTitulo($titulo){
        $query = $this->db->prepare('SELECT * FROM Encuesta WHERE "titulo" = ?');
        $query->execute(array($titulo));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getRespondidas($idEncuesta, $idOpcion){
        $query = $this->db->prepare('SELECT COUNT(*) FROM Respuesta WHERE "id_encuesta" = ? and "id_opcion" = ? ');
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getOpciones($idEncuesta){
        $query = $this->db->prepare('SELECT * FROM Opcion WHERE "id_encuesta" = ?');
        return $query->fetch(PDO::FETCH_OBJ); 
    }

    public function getTotalRespuestas($idEncuesta){
        $query = $this->db->prepare('SELECT COUNT(*) FROM Respuesta WHERE "id_encuesta" = ?');
        $query->execute(array($idEncuesta));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getVoto($idEncuesta, $idUser){
        $query = $this->db->prepare('SELECT * FROM Respuesta WHERE "id_encuesta" = ? and "id_usuario" = ?');
        $query->execute(array($idEncuesta, $idUser));
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    public getRespuesta($idEncuesta, $idOpcion, $idUser){
        $query = $this->db->prepare('SELECT * FROM Respuesta WHERE "id_encuesta" = ?and "id_opcion" = ? and "id_user" = ?' );
        $query->execute(array($idEncuesta, $idOpcion, $idUser));
        return $query->fetch(PDO::FETCH_OBJ);
    }

}