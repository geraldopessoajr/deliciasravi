<?php

  class Pedido{
      
      private $ped_codigo;
      private $ped_data_entrega;
      private $ped_hora_entrega; 
      private $cli_codigo;
      private $cli_nome;
      private $cli_endereco;
      private $cli_referencia;
      private $cli_contato; 
      private $st_codigo;
      private $st_descricao;
      private $itens;

      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

