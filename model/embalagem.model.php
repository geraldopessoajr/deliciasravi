<?php

  class Embalagem{
      
      private $emb_codigo;
      private $emb_descricao;
      private $emb_qtde;
      
      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

