<?php

class ProdutoService {
    
    private $conexao;
    private $produto;
    
    
    public function __construct(Conexao $conexao, Produto $produto)
    {
        $this->conexao = $conexao->conectar();
        $this->produto = $produto;
    }
    
    
    public function inserir(){
        $query = 'insert into tb_produto(prod_descricao, prod_sabor, prod_preco, emb_codigo) values (:descricao, :sabor, :preco, :emb_cod)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':descricao', $this->produto->__get('prod_descricao'));
        $stmt->bindValue(':sabor', $this->produto->__get('prod_sabor'));
        $stmt->bindValue(':preco', $this->produto->__get('prod_preco'));
        $stmt->bindValue(':emb_cod', $this->produto->__get('emb_codigo'));
        $stmt->execute();
    }
 
   
    public function recuperar($query){
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function qtde_registros()
    {
        $query = 'select count(prod_codigo) from tb_produto';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function atualizar(){
        $query = "update tb_produto set prod_descricao = ?, prod_sabor = ?, prod_preco = ?, emb_codigo = ? where prod_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->produto->__get('prod_descricao'));
        $stmt->bindValue(2, $this->produto->__get('prod_sabor'));
        $stmt->bindValue(3, $this->produto->__get('prod_preco'));
        $stmt->bindValue(4, $this->produto->__get('emb_codigo'));
        $stmt->bindValue(5, $this->produto->__get('prod_codigo'));
        return $stmt->execute();
    }
    
    public function remover(){
        echo $this->produto->__get('prod_codigo');
        $query = "delete from tb_produto where prod_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->produto->__get('prod_codigo'));
        return $stmt->execute();
        
    }
}
