<?php

  class Usuario{
      
      private $usu_codigo;
      private $usu_nome;
      private $usu_username;
      private $usu_senha;
      private $usu_perfil;
      
      public function __get($atributo) {
          return $this->$atributo;
      }
      
      public function __set($atributo, $value) {
          $this->$atributo = $value;
      }
  }
  
  

