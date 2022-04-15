<?php
    
    echo getcwd();
  
    $acao = 'recuperar';
    require '../controller/usuario.controller.php';

    session_start();
        
    print_r($_SESSION);

    $usuario_autenticado = false;
    $usuario_id = 1;
    
    //$perfil_usuarios = array(1 => 'Administrativo', 2=> 'Usuário');
    
    foreach($usuarios as $user){
        if($user->usu_username == $_POST['username'] && $user->usu_senha == $_POST['senha'])
        {
            $usuario_autenticado = true;
            $usuario_id = $user->usu_codigo;
            $usuario_perfil_id = $user->usu_perfil;
        }
    }
    
    if($usuario_autenticado)
    {
        $_SESSION['autenticado'] = 'sim';
        $_SESSION['id'] = $usuario_id;
        $_SESSION['perfil_id'] = $usuario_perfil_id;
        header('Location: home.php');
    }
    else
    {
        $_SESSION['autenticado'] = 'nao';
        header('Location: ../index.php?login=erro2');
    }


