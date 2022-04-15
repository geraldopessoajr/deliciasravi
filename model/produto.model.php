<?php

  class Produto{
      
      private $emb_codigo;
      private $prod_codigo;
      private $prod_descricao; 
      private $prod_preco;
      private $prod_sabor;
      private $emb_qtde;

      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

