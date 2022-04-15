<?php

class EmbalagemService {
    
    private $conexao;
    private $embalagem;
    
    
    public function __construct(Conexao $conexao, Embalagem $embalagem)
    {
        $this->conexao = $conexao->conectar();
        $this->embalagem = $embalagem;
    }
    
    
    public function inserir(){
        $query = 'insert into tb_embalagem(emb_descricao, emb_qtde) values (:descricao, :qtde)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':descricao', $this->embalagem->__get('emb_descricao'));
        $stmt->bindValue(':qtde', $this->embalagem->__get('emb_qtde'));
        $stmt->execute();
    }
   
    public function recuperar($query){
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function qtde_registros()
    {
        $query = 'select count(emb_codigo) from tb_embalagem';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function atualizar(){
        $query = "update tb_embalagem set emb_descricao = ?, emb_qtde = ? where emb_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->embalagem->__get('emb_descricao'));
        $stmt->bindValue(2, $this->embalagem->__get('emb_qtde'));
        $stmt->bindValue(3, $this->embalagem->__get('emb_codigo'));
        return $stmt->execute();
    }
    
    public function remover(){
        $query = "delete from tb_embalagem where emb_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->embalagem->__get('emb_codigo'));
        return $stmt->execute();
        
    }
}
