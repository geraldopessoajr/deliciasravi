<?php

class UsuarioService {
    
    private $conexao;
    private $usuario;
    
    
    public function __construct(Conexao $conexao, Usuario $usuario)
    {
        $this->conexao = $conexao->conectar();
        $this->usuario = $usuario;
    }
    
    
    public function inserir(){
        $query = 'insert into tb_usuario(usu_nome, usu_username, usu_senha, usu_perfil) values (:nome, :username, :senha, :perfil)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':nome', $this->usuario->__get('usu_nome'));
        $stmt->bindValue(':username', $this->usuario->__get('usu_username'));
        $stmt->bindValue(':senha', $this->usuario->__get('usu_senha'));
        $stmt->bindValue(':perfil', $this->usuario->__get('usu_perfil'));
        $stmt->execute();
    }
 
   
    public function recuperar($query){
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
        public function qtde_registros()
    {
        $query = 'select count(usu_codigo) from tb_usuario';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function atualizar(){
        $query = "update tb_usuario set usu_nome = ?, usu_username = ?, usu_senha = ?, usu_perfil = ? where usu_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->usuario->__get('usu_nome'));
        $stmt->bindValue(2, $this->usuario->__get('usu_username'));
        $stmt->bindValue(3, $this->usuario->__get('usu_senha'));
        $stmt->bindValue(4, $this->usuario->__get('usu_perfil'));
        $stmt->bindValue(5, $this->usuario->__get('usu_codigo'));
        return $stmt->execute();
    }

     public function senha(){
        $query = "update tb_usuario set usu_senha = ? where usu_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->usuario->__get('usu_senha'));
        $stmt->bindValue(2, $this->usuario->__get('usu_codigo'));
        return $stmt->execute();
    }
    
    public function remover(){
        $query = "delete from tb_usuario where usu_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->usuario->__get('usu_codigo'));
        return $stmt->execute();
        
    }
}
