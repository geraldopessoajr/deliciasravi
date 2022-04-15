<?php

   require "../model/usuario.model.php";
   require "../model/usuario.service.php";
   require "../model/conexao.php";
   
   $acao = isset($acao) ? $acao : "";
   if($acao == "")
   {
       $acao = isset($_GET['acao']) ? $_GET['acao'] : filter_input(INPUT_POST, 'acao');
   }

   if($acao == 'inserir')
   {
        $usuario = new Usuario();

        $usuario->__set('usu_nome', $_POST['nome']);
        $usuario->__set('usu_username', $_POST['username']);
        $usuario->__set('usu_senha', $_POST['senha']);
        $usuario->__set('usu_perfil', $_POST['perfil']);

        $conexao = new Conexao();

        $usuarioService = new UsuarioService($conexao, $usuario);
        $usuarioService->inserir();

        header('Location: ../view/usuario.novo.php?inclusao=1');
   }
   else if($acao == 'recuperar')
   {
       $usuario = new Usuario();
       $conexao = new Conexao();
       
       $usuarioService = new UsuarioService($conexao, $usuario);
       $usuarios = $usuarioService->recuperar('select u.usu_codigo, u.usu_nome, u.usu_username, u.usu_senha, u.usu_perfil
            from tb_usuario as u
            order by u.usu_nome');
   }
   else if($acao == 'recuperar_lista')
   {
       $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
       $it_pagina = filter_input(INPUT_POST, 'it_pagina', FILTER_SANITIZE_NUMBER_INT);
       $inicio = (($pagina-1)*$it_pagina);
       
       $usuario = new Usuario();
       $conexao = new Conexao();
       
       $usuarioService = new UsuarioService($conexao, $usuario);
       $usuarios = $usuarioService->recuperar(
            'select u.usu_codigo, u.usu_nome, u.usu_username, u.usu_senha, u.usu_perfil
            from tb_usuario as u
            order by u.usu_nome
            limit '.$inicio.', '.$it_pagina);
        
       ?>         
            <h4>Usuários</h4>
            <hr />
            <table class="table table-striped table_bordered">
                 <thead>
                     <th>Nome</th>
                     <th>Username</th>
                     <th>Perfil</th>
                     <th></th>
                 </thead>
                <?php  foreach($usuarios as $usuario){ ?>
                        <tr>

                            <div class="col-sm-12" id="usuario_<?= $usuario->usu_codigo ?>">
                                <td><?= $usuario->usu_nome ?></td>
                                <td><?= $usuario->usu_username ?></td>
                                <td><?= $usuario->usu_perfil?></td> 
                            </div>
                            <td>
                                <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover( <?= $usuario->usu_codigo ?>)"></i>
                                <i class="fas fa-edit fa-lg text-info" onclick="editar( <?= $usuario->usu_codigo ?>, '<?= $usuario->usu_nome ?>', '<?= $usuario->usu_username ?>', '<?= $usuario->usu_senha ?>', '<?= $usuario->usu_perfil ?>', <?= $pagina ?>, <?= $it_pagina ?>)"></i>
                            </td>
                        </tr>
                <?php } ?>
            </table>
            <?php $qtde_registros = $usuarioService->qtde_registros();
                  $pagina_final = ceil($qtde_registros/$it_pagina);
                  if($qtde_registros > $it_pagina){?>
                    <div id="pag">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li id="li_1" class="page-item">
                                    <a href="#" onclick='listar_usuario(1, <?= $it_pagina?>)' class="page-link"><span>&laquo;</span></a>
                                </li>

                                <?php if($pagina > 1) {?>
                                    <div id="first">
                                        <li class="page-item">
                                            <a href="#" onclick='listar_usuario(<?= ($pagina-1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina-1)?></a>
                                        </li>
                                    </div>
                                <?php } ?>

                                <li class="page-item active">
                                    <a href="#" class="page-link"><?= $pagina?></a>
                                </li>

                                <?php if($pagina < $pagina_final) {?>
                                    <div id="second">
                                        <li class="page-item">
                                            <a href="#" onclick='listar_usuario(<?= ($pagina+1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina+1)?></a>
                                        </li>
                                    </div>
                                <?php } ?>

                                <li id="li_5" class="page-item">
                                    <a href="#" onclick='listar_usuario(<?= $pagina_final?>, <?= $it_pagina?>)' class="page-link"><span>&raquo;</span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                
               <?php }
   }
   else if($acao == 'editar')
   {
       $id = filter_input(INPUT_POST, 'id');
       $nome = filter_input(INPUT_POST, 'nome');
       $username = filter_input(INPUT_POST, 'username');
       $senha = filter_input(INPUT_POST, 'senha');
       $perfil = filter_input(INPUT_POST, 'perfil');
       $pagina = filter_input(INPUT_POST, 'pagina');
       $it_pagina = filter_input(INPUT_POST, 'it_pagina');
       
       ?> 
        <h4>Editar Usuário</h4>
        <hr />

        <form method="post" action="../controller/usuario.controller.php?acao=atualizar">
                <div class="form-group">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <label>Nome:</label>
                        <input type="text" class="form-control is-valid" name="nome" required value="<?= $nome?>">
                        </br>
                        <label>Username:</label>
                        <input type="text" class="form-control is-valid" name="username" required value="<?= $username?>">
                        </br>
                        <label>Senha: (mínimo 6 dígitos)</label>
                        <input type="password" class="form-control is-valid" name="senha" required value="<?= $senha?>">
                        </br>
                        <label>Perfil:</label>
                        <select class="form-select is-valid" name="perfil" required>
                            <?php if($perfil == 1){ ?>
                                <option value="1" selected>Administrador</option>
                                <option value="2" >Usuário</option>
                            <?php } else { ?>
                                <option value="1" >Administrador</option>
                                <option value="2" selected>Usuário</option>
                            <?php } ?>
                        </select></br>
                </div></br>

                <button class="btn btn-success">Atualizar</button>
                <input class="btn btn-danger" type="button" value="Cancelar" onclick="listar_usuario(<?= $pagina?>, <?= $it_pagina?>)">
        </form>
       
       <?php
   }
   else if($acao == 'atualizar')
   {
       $usuario = new Usuario();
       $usuario->__set('usu_codigo', $_POST['id']);
       $usuario->__set('usu_nome', $_POST['nome']);
       $usuario->__set('usu_username', $_POST['username']);     
       $usuario->__set('usu_senha', $_POST['senha']);
       $usuario->__set('usu_perfil', $_POST['perfil']);
       
       $conexao = new Conexao();
       
       $usuarioService = new UsuarioService($conexao, $usuario);
       if($usuarioService->atualizar()) {
           header('location: ../view/usuario.consulta.php');
       }
   }
   else if($acao == 'remover')
   {
       $usuario = new Usuario();
       $usuario->__set('usu_codigo', $_GET['id']);
       
       $conexao = new Conexao();
       
       $usuarioService = new UsuarioService($conexao, $usuario);
       if($usuarioService->remover()) {
	  header('location: ../view/usuario.consulta.php');
       }
   }
   else if($acao == 'senha')
   {
       $usuario = new Usuario();
       $usuario->__set('usu_codigo', $_GET['id']);
       $usuario->__set('usu_senha', $_POST['senha']);
       
       $conexao = new Conexao();
       
       $usuarioService = new UsuarioService($conexao, $usuario);
       if($usuarioService->senha()) {
	  header('location: ../view/senha.novo.php?inclusao=1');
       }
   }

