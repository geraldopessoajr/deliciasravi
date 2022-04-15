<?php

   require "../model/cliente.model.php";
   require "../model/cliente.service.php";
   require "../model/conexao.php";
   
   $acao = isset($acao) ? $acao : "";
   if($acao == "")
   {
       $acao = isset($_GET['acao']) ? $_GET['acao'] : filter_input(INPUT_POST, 'acao');
   }

   if($acao == 'inserir')
   {
        $cliente = new Cliente();

        $cliente->__set('cli_nome', $_POST['nome']);
        $cliente->__set('cli_contato', $_POST['contato']);
        $cliente->__set('cli_endereco', $_POST['endereco']);
        $cliente->__set('cli_referencia', $_POST['referencia']);

        $conexao = new Conexao();


        $clienteService = new ClienteService($conexao, $cliente);
        $clienteService->inserir();

        header('Location: ../view/cliente.novo.php?inclusao=1');
   }
   else if($acao == 'recuperar')
   {
       $cliente = new Cliente();
       $conexao = new Conexao();
       
       $clienteService = new ClienteService($conexao, $cliente);
       $clientes = $clienteService->recuperar();
   }
   else if($acao == 'recuperar_lista')
   {
       $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
       $it_pagina = filter_input(INPUT_POST, 'it_pagina', FILTER_SANITIZE_NUMBER_INT);
       $inicio = (($pagina-1)*$it_pagina);
       
       $cliente = new Cliente();
       $conexao = new Conexao();
       
       $clienteService = new ClienteService($conexao, $cliente);
       $clientes = $clienteService->recuperar(
            'select c.cli_codigo, c.cli_nome, c.cli_contato, c.cli_endereco, c.cli_referencia
            from tb_cliente as c 
            order by c.cli_nome
            limit '.$inicio.', '.$it_pagina);
       ?>          
            <h4>Clientes</h4>
            <hr />
            <table class="table table-striped table_bordered">
                <thead>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Endereço</th>
                    <th></th>
                </thead>
                <?php 
                    foreach($clientes as $cliente){ ?>
                        <tr>

                            <div class="col-sm-12" id="cliente_<?= $cliente->cli_codigo ?>">
                                <td><?= $cliente->cli_nome ?></td>
                                <td><?= $cliente->cli_contato ?></td>
                                <td><?= $cliente->cli_endereco?></td> 
                            </div>
                            <td>
                                <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover( <?= $cliente->cli_codigo ?> )"></i>
                                <i class="fas fa-edit fa-lg text-info" onclick="editar( <?= $cliente->cli_codigo ?>, '<?= $cliente->cli_nome ?>', '<?= $cliente->cli_contato ?>', '<?= $cliente->cli_endereco ?>',  '<?= $cliente->cli_referencia ?>', <?= $pagina ?>, <?= $it_pagina ?> )"></i>
                            </td>
                <?php } ?>
            </table>
            <?php $qtde_registros = $clienteService->qtde_registros();
                  $pagina_final = ceil($qtde_registros/$it_pagina);
                  if($qtde_registros > $it_pagina){?>
                    <div id="pag">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a href="#" onclick='listar_cliente(1, <?= $it_pagina?>)' class="page-link"><span>&laquo;</span></a>
                                </li>

                                <?php if($pagina > 1) {?>
                                    <li class="page-item">
                                        <a href="#" onclick='listar_cliente(<?= ($pagina-1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina-1)?></a>
                                    </li>
                                <?php }?>
                                

                                <li class="page-item active">
                                    <a href="#" class="page-link"><?= $pagina?></a>
                                </li>

                                
                                <?php if($pagina < $pagina_final) {?>
                                    <li class="page-item">
                                        <a href="#" onclick='listar_cliente(<?= ($pagina+1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina+1)?></a>
                                    </li>
                                <?php }?>

                                <li class="page-item">
                                    <a href="#" onclick='listar_cliente(<?= $pagina_final?>, <?= $it_pagina?>)' class="page-link"><span>&raquo;</span></a>
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
       $contato = filter_input(INPUT_POST, 'contato');
       $endereco = filter_input(INPUT_POST, 'endereco');
       $referencia = filter_input(INPUT_POST, 'referencia');
       $pagina = filter_input(INPUT_POST, 'pagina');
       $it_pagina = filter_input(INPUT_POST, 'it_pagina');
       
       ?> 
        <h4>Editar Cliente</h4>
        <hr />

        <form method="post" action="../controller/cliente.controller.php?acao=atualizar">
                <div class="form-group">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <label>Nome:</label>
                        <input type="text" class="form-control is-valid" name="nome" required value="<?= $nome?>">
                        </br>
                        <label>Contato:</label>
                        <input type="text" class="form-control is-valid" name="contato" required value="<?= $contato?>">
                        </br>
                        <label>Endereço:</label>
                        <input type="text" class="form-control is-valid" name="endereco" required value="<?= $endereco?>">
                        </br>
                        <label>Ponto de Referência:</label>
                        <input type="text" class="form-control" name="referencia" value="<?= $referencia?>">
                </div></br>

                <button class="btn btn-success">Atualizar</button>
                <input class="btn btn-danger" type="button" value="Cancelar" onclick="listar_cliente(<?= $pagina?>, <?= $it_pagina?>)">
        </form>
       
       <?php
   }
   else if($acao == 'atualizar')
   {
       $cliente = new Cliente();
       $cliente->__set('cli_codigo', $_POST['id']);
       $cliente->__set('cli_nome', $_POST['nome']);
       $cliente->__set('cli_contato', $_POST['contato']);
       $cliente->__set('cli_endereco', $_POST['endereco']);
       $cliente->__set('cli_referencia', $_POST['referencia']);
       
       $conexao = new Conexao();
       
       $clienteService = new ClienteService($conexao, $cliente);
       if($clienteService->atualizar()) {
           header('location: ../view/cliente.consulta.php');
       }
   }
   else if($acao == 'remover')
   {
       $cliente = new Cliente();
       $cliente->__set('cli_codigo', $_GET['id']);
       
       $conexao = new Conexao();
       
       $clienteService = new ClienteService($conexao, $cliente);
       if($clienteService->remover()) {
	  header('location: ../view/cliente.consulta.php');
       }
   }

