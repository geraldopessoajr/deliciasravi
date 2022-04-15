<?php

   require "../model/embalagem.model.php";
   require "../model/embalagem.service.php";
   require "../model/conexao.php";
   
   $acao = isset($acao) ? $acao : "";
   if($acao == "")
   {
       $acao = isset($_GET['acao']) ? $_GET['acao'] : filter_input(INPUT_POST, 'acao');
   }
   
   if($acao == 'inserir')
   {
        $embalagem = new Embalagem();

        $embalagem->__set('emb_descricao', $_POST['descricao']);
        $embalagem->__set('emb_qtde', $_POST['qtde']);

        $conexao = new Conexao();


        $embalagemService = new EmbalagemService($conexao, $embalagem);
        $embalagemService->inserir();

        header('Location: ../view/embalagem.novo.php?inclusao=1');
   }
   else if($acao == 'recuperar')
   {
       $embalagem = new Embalagem();
       $conexao = new Conexao();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       $embalagens = $embalagemService->recuperar(
            'select t.emb_codigo, t.emb_descricao, t.emb_qtde
             from tb_embalagem as t
             order by t.emb_descricao');
   }
   else  if($acao == 'recuperar_lista')
   {
       $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
       $it_pagina = filter_input(INPUT_POST, 'it_pagina', FILTER_SANITIZE_NUMBER_INT);
       $inicio = (($pagina-1)*$it_pagina);
       
       $embalagem = new Embalagem();
       $conexao = new Conexao();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       $embalagens = $embalagemService->recuperar(
            'select t.emb_codigo, t.emb_descricao, t.emb_qtde
             from tb_embalagem as t
             order by t.emb_descricao
             limit '.$inicio.', '.$it_pagina);
       ?>
            <h4>Embalagens em Estoque</h4>
            <hr />
            <table class="table table-striped table_bordered">
                <thead>
                    <th>Embalagem</th>
                    <th text-align="center">Quantidade</th>
                    <th></th>
                </thead>
                <?php foreach($embalagens as $embalagem){  ?>
                        <tr>
                            <div class="col-sm-12" id="embalagem_<?= $embalagem->emb_codigo ?>">
                                <td><?= $embalagem->emb_descricao ?></td>
                                <td><?= $embalagem->emb_qtde ?></td>
                            </div>
                            <td align="right">
                                <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover( <?= $embalagem->emb_codigo ?>)"></i>
                                <i class="fas fa-edit fa-lg text-info" onclick="editar( <?= $embalagem->emb_codigo ?>, '<?= $embalagem->emb_descricao ?>', '<?= $embalagem->emb_qtde ?>', <?= $pagina ?>, <?= $it_pagina ?>)"></i>
                            </td>
                        </tr>
                <?php } ?>

            </table>
            <?php $qtde_registros = $embalagemService->qtde_registros();
                  $pagina_final = ceil($qtde_registros/$it_pagina);
                  if($qtde_registros > $it_pagina){?>
                    <div id="pag">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li id="li_1" class="page-item">
                                    <a href="#" onclick='listar_embalagem(1, <?= $it_pagina?>)' class="page-link"><span>&laquo;</span></a>
                                </li>

                                <?php if($pagina > 1) {?>
                                    <li class="page-item">
                                        <a href="#" onclick='listar_embalagem(<?= ($pagina-1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina-1)?></a>
                                    </li>
                                <?php }?>
                                
                                <li class="page-item active">
                                    <a href="#" class="page-link"><?= ($pagina)?></a>
                                </li>

                                <?php if($pagina < $pagina_final) {?>
                                    <li class="page-item">
                                        <a href="#" onclick='listar_embalagem(<?= ($pagina+1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina+1)?></a>
                                    </li>
                                <?php }?>

                                <li id="li_5" class="page-item">
                                    <a href="#" onclick='listar_embalagem(<?= $pagina_final?>, <?= $it_pagina?>)' class="page-link"><span> &raquo;</span></a>
                                </li>
                            </ul>
                        </nav>
                    </div> 
                
               <?php }
   }
   else if($acao == 'editar')
   {
       $id = filter_input(INPUT_POST, 'id');
       $descricao = filter_input(INPUT_POST, 'descricao');
       $qtde = filter_input(INPUT_POST, 'qtde');
       $pagina = filter_input(INPUT_POST, 'pagina');
       $it_pagina = filter_input(INPUT_POST, 'it_pagina');
       
       ?> 
        <h4>Editar Embalagem</h4>
        <hr />

        <form method="post" action="../controller/embalagem.controller.php?acao=atualizar">
                <div class="form-group">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <label>Descrição:</label>
                        <input type="text" class="form-control is-valid" name="descricao" required value="<?= $descricao?>">
                        </br>
                        <label>Quantidade:</label>
                        <input type="number" class="form-control is-valid" name="qtde" min="0" required value="<?= $qtde?>">
                </div></br>

                <button class="btn btn-success">Atualizar</button>
                <input class="btn btn-danger" type="button" value="Cancelar" onclick="listar_embalagem(<?= $pagina?>, <?= $it_pagina?>)">
        </form>
       
       <?php
   }
   else if($acao == 'atualizar')
   {
       $embalagem = new Embalagem();
       $embalagem->__set('emb_codigo', $_POST['id']);
       $embalagem->__set('emb_descricao', $_POST['descricao']);
       $embalagem->__set('emb_qtde', $_POST['qtde']);
       
       $conexao = new Conexao();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       if($embalagemService->atualizar()) {
           header('location: ../view/embalagem.consulta.php');
       }
   }
   else if($acao == 'remover')
   {
       $embalagem = new Embalagem();
       $embalagem->__set('emb_codigo', $_GET['id']);
       
       $conexao = new Conexao();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       if($embalagemService->remover()) {
	  header('location: ../view/embalagem.consulta.php');
       }
   }

