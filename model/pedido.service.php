<?php

class PedidoService {
    
    private $conexao;
    private $pedido;
    
    
    public function __construct(Conexao $conexao, Pedido $pedido)
    {
        $this->conexao = $conexao->conectar();
        $this->pedido = $pedido;
    }
    
    
    public function inserir(){
        $query = 'insert into tb_pedido(ped_data_entrega, ped_hora_entrega, cli_codigo, st_codigo) values (:data_entrega, :hora_entrega, :cli_id, :st_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_entrega', $this->pedido->__get('ped_data_entrega'));
        $stmt->bindValue(':hora_entrega', $this->pedido->__get('ped_hora_entrega'));
        $stmt->bindValue(':cli_id', $this->pedido->__get('cli_codigo'));
        $stmt->bindValue(':st_id', $this->pedido->__get('st_codigo'));
        $stmt->execute();
    }
 
   
    public function recuperar($sql){
        $query = 'select p.ped_codigo, p.ped_data_entrega, p.ped_hora_entrega, p.cli_codigo, c.cli_nome, c.cli_endereco, c.cli_referencia, c.cli_contato, p.st_codigo, s.st_descricao from tb_pedido as p join tb_cliente as c on p.cli_codigo = c.cli_codigo join tb_status s on p.st_codigo = s.st_codigo'.$sql;
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();     
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
 
   
    public function recuperarCodigo(){
        $query = 'select max(p.ped_codigo) as ped_codigo
                    from tb_pedido as p ';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function qtde_registros()
    {
        $query = 'select count(ped_codigo) from tb_pedido';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetch();
        $result[0];
        return $result[0];
    }
    
    public function atualizar(){
        $query = "update tb_pedido set ped_data_entrega = ?, ped_hora_entrega = ? where ped_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->pedido->__get('ped_data_entrega'));
        $stmt->bindValue(2, $this->pedido->__get('ped_hora_entrega'));
        $stmt->bindValue(3, $this->pedido->__get('ped_codigo'));
        return $stmt->execute();
    }
    
    public function entregar(){
        $query = "update tb_pedido set st_codigo = 2 where ped_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->pedido->__get('ped_codigo'));
        return $stmt->execute();
    }
    
    public function remover(){
        $query = "delete from tb_pedido where ped_codigo = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->pedido->__get('ped_codigo'));
        return $stmt->execute();
        
    }
}
