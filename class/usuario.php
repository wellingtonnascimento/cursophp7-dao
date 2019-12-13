<?php

class Usuario {

    private $idUsuario;
    private $desLogin;
    private $desSenha;
    private $dtCadastro;


    public function getIdusuario(){

        return $this->idUsuario;
    }

    public function setIdusuairo($value){

        $this->idUsuario = $value;
    }

    public function getDeslogin(){

        return $this->desLogin;
    }

    public function setDeslogin($value){

        $this->desLogin = $value;
    }

    public function getDessenha(){

        return $this->desSenha;
    }

    public function setDessenha($value){

        $this->desSenha = $value;
    }

    public function getDtcadastro(){

        return $this->dtCadastro;
    }

    public function setDtcadastro($value){

        $this->dtCadastro = $value;
    }


    public function loadByid($id){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idUsuario = :ID", array(
            ":ID"=>$id
        ));

        if(count($results) > 0){

            $row = $results[0];

            $this->setIdusuairo($row['idUsuario']);
            $this->setDeslogin($row['desLogin']);
            $this->setDessenha($row['desSenha']);
            $this->setDtcadastro(new DateTime($row['dtCadastro']));
        }

    }

    public static function getList(){

        $sql = new Sql();
        
       return $sql->select("SELECT * FROM tb_usuarios ORDER BY desLogin");
    }

    public static function search($login){
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_usuarios WHERE desLogin LIKE :SEARCH ORDER BY desLogin", array(
            ':SEARCH'=>"%".$login."%"
        ));
    }

    public function login($login, $password){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE desLogin = :LOGIN AND desSenha = :PASSWORD ", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($results) > 0){

            $row = $results[0];

            $this->setIdusuairo($row['idUsuario']);
            $this->setDeslogin($row['desLogin']);
            $this->setDessenha($row['desSenha']);
            $this->setDtcadastro(new DateTime($row['dtCadastro']));
        }else{

            throw new Exception("Login e/ou senha inválidos.");
        }


    }

    public function __toString()
    {
        return json_encode(array(
            "idUsuario"=>$this->getIdusuario(),
            "desLogin"=>$this->getDeslogin(),
            "desSenha"=>$this->getDessenha(),
            "dtCadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
        ));
    }


}


?>