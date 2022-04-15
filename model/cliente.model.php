<?php

  class Cliente{
      
      private $cli_codigo;
      private $cli_nome;
      private $cli_contato;
      private $cli_endereco;
      private $cli_referencia;
      
      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

