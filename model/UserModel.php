<?php

class User extends PDO {

    function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=encuesta;charset=utf8', 'root', '');
    }

    public function GetPassword($user){
        $sentencia = $this->db->prepare( "SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $sentencia->execute(array($user));
        $pass = $sentencia->fetch(PDO::FETCH_OBJ);
        
        return $pass;
    }

    public function Registro($user, $pass){
        $sentencia = $this->db->prepare("INSERT INTO usuarios (nombre_usuario, clave) VALUES(?,?)");
        $sentencia->execute(array($user, $pass));
    }

    public function eliminarUser($id){
        $sentencia = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        $sentencia->execute(array($id));
    }

    public function editarAdmin($id, $valor){
        $sentencia = $this->db->prepare("UPDATE usuarios SET administrador = ? WHERE id = ?");
        $sentencia->execute(array($valor, $id));
    }

    public function getUsuarios(){
        $sentencia = $this->db->prepare( "SELECT * FROM usuarios");
        $sentencia->execute();
        
        $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    
    }
}