<?php

class Item_PedidoService {
    
    private $conexao;
    private $item_pedido;
    
    
    public function __construct(Conexao $conexao, Item_Pedido $item_pedido)
    {
        $this->conexao = $conexao->conectar();
        $this->item_pedido = $item_pedido;
    }
    
    
    public function inserir($ip_quantidade, $ped_codigo, $prod_codigo){
        $query = 'insert into tb_item_pedido(ip_qtde, ped_codigo, prod_codigo) values (:qtde, :ped_id, :prod_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':qtde', $ip_quantidade);
        $stmt->bindValue(':ped_id', $ped_codigo);
        $stmt->bindValue(':prod_id', $prod_codigo);
        $stmt->execute();
    }
    
    public function atualizar($ip_codigo, $ip_quantidade, $ped_codigo, $prod_codigo){
        $query = 'insert into tb_item_pedido(ip_codigo, ip_qtde, ped_codigo, prod_codigo) values (:ip_id, :qtde, :ped_id, :prod_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':ip_id', $ip_codigo);
        $stmt->bindValue(':qtde', $ip_quantidade);
        $stmt->bindValue(':ped_id', $ped_codigo);
        $stmt->bindValue(':prod_id', $prod_codigo);
        $stmt->execute();
    }

    public function diminuiEmbalagem($ip_quantidade, $prod_codigo){
        $query = 'update tb_embalagem e set emb_qtde = emb_qtde-:qtde where emb_codigo = (select p.emb_codigo from tb_produto p where p.prod_codigo = :prod_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':qtde', $ip_quantidade);
        $stmt->bindValue(':prod_id', $prod_codigo);
        $stmt->execute();
    }

    public function aumentaEmbalagem($ip_codigo, $prod_codigo){
        $query = 'update tb_embalagem e set emb_qtde = emb_qtde + (select i.ip_qtde from tb_item_pedido i where i.ip_codigo = :ip_id) where emb_codigo = (select p.emb_codigo from tb_produto p where p.prod_codigo = :prod_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':ip_id', $ip_codigo);
        $stmt->bindValue(':prod_id', $prod_codigo);
        $stmt->execute();
    }
   
    public function recuperar($ped_codigo){
        $query = 'SELECT ip.ip_codigo, ip.ip_qtde, ip.ped_codigo, p.prod_codigo, p.prod_descricao, p.prod_sabor, p.prod_preco from tb_item_pedido as ip join tb_produto as p  on p.prod_codigo = ip.prod_codigo where ip.ped_codigo = ? ';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $ped_codigo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function remover($ped_codigo){
        $query = "delete from tb_item_pedido where ped_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $ped_codigo);
        return $stmt->execute();
        
    }
}
