<?php

  class Item_Pedido{
      
      private $ip_codigo;
      private $ip_qtde;
      private $ped_codigo; 
      private $prod_codigo;
      private $prod_descricao;
      private $prod_sabor;
      private $prod_preco;

      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

