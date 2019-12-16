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

            $this->setData($results[0]);

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

            $this->setData($results[0]);

        }else{
            throw new Exception("Login e/ou senha inválidos.");
        }
    }

    public function setData($data){

        $this->setIdusuairo($data['idUsuario']);
        $this->setDeslogin($data['desLogin']);
        $this->setDessenha($data['desSenha']);
        $this->setDtcadastro(new DateTime($data['dtCadastro']));


    }

    public function insert(){

        $sql = new Sql();
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)",array(
            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha()
        ));

        if(count($results)>0){
            $this->setData($results[0]);
        }

    }

    public function update($login, $password){

        $this->setDeslogin($login);
        $this->setDessenha($password);

        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET desLogin = :LOGIN, desSenha = :PASSWORD WHERE idUsuario = :ID",array(
           ':LOGIN'=>$this->getDeslogin(),
           ':PASSWORD'=>$this->getDessenha(),
           ':ID'=>$this->getIdusuario()
        ));
    }


    public function delete(){
        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios WHERE idUsuario = :ID",array(
            ':ID'=>$this->getIdusuario()
        ));

        $this->setIdusuairo(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());

    }

    public function __construct($login = "", $password = ""){

        $this->setDeslogin($login);
        $this->setDessenha($password);

        
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