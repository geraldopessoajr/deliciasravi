<?php

class ClienteService {
    
    private $conexao;
    private $cliente;
    
    
    public function __construct(Conexao $conexao, Cliente $cliente)
    {
        $this->conexao = $conexao->conectar();
        $this->cliente = $cliente;
    }
    
    
    public function inserir(){
        $query = 'insert into tb_cliente(cli_nome, cli_contato, cli_endereco, cli_referencia) values (:nome, :contato, :endereco, :referencia)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':nome', $this->cliente->__get('cli_nome'));
        $stmt->bindValue(':contato', $this->cliente->__get('cli_contato'));
        $stmt->bindValue(':endereco', $this->cliente->__get('cli_endereco'));
        $stmt->bindValue(':referencia', $this->cliente->__get('cli_referencia'));
        $stmt->execute();
    }
 
   
    public function recuperar($query){
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
 
   
    public function recuperarCodigo(){
        $query = 'select max(c.cli_codigo) as cli_codigo
                    from tb_cliente as c ';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function qtde_registros()
    {
        $query = 'select count(cli_codigo) from tb_cliente';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function atualizar(){
        $query = "update tb_cliente set cli_nome = ?, cli_contato = ?, cli_endereco = ?, cli_referencia = ? where cli_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->cliente->__get('cli_nome'));
        $stmt->bindValue(2, $this->cliente->__get('cli_contato'));
        $stmt->bindValue(3, $this->cliente->__get('cli_endereco'));
        $stmt->bindValue(4, $this->cliente->__get('cli_referencia'));
        $stmt->bindValue(5, $this->cliente->__get('cli_codigo'));
        return $stmt->execute();
    }
    
    public function remover(){
        $query = "delete from tb_cliente where cli_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->cliente->__get('cli_codigo'));
        return $stmt->execute();
        
    }
}
