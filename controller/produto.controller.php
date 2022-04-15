<?php

   require "../model/produto.model.php";
   require "../model/embalagem.model.php";
   require "../model/produto.service.php";
   require "../model/embalagem.service.php";
   require "../model/conexao.php";
   
   $acao = isset($acao) ? $acao : "";
   if($acao == "")
   {
       $acao = isset($_GET['acao']) ? $_GET['acao'] : filter_input(INPUT_POST, 'acao');
   }
   
   if($acao == 'inserir')
   {
        $produto = new Produto();

        $produto->__set('prod_descricao', $_POST['descricao']);
        $produto->__set('prod_sabor', $_POST['sabor']);
        $preco = $_POST['preco']; 
        $preco = str_replace(',', '.', $preco);
        $produto->__set('prod_preco', $preco);
        $emb_id = $_POST['emb_id'];
        if($emb_id > 0)
            $produto->__set('emb_codigo', $emb_id);

        $conexao = new Conexao();


        $produtoService = new ProdutoService($conexao, $produto);
        $produtoService->inserir();

        header('Location: ../view/produto.novo.php?inclusao=1');
   }
   else if($acao == 'recuperar')
   {
       $conexao = new Conexao();
       $embalagem = new Embalagem();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       $embalagens = $embalagemService->recuperar('select t.emb_codigo,
                t.emb_descricao, t.emb_qtde
            from tb_embalagem as t
            order by t.emb_descricao');

       $produto = new Produto();
       
       $produtoService = new ProdutoService($conexao, $produto);
       $produtos = $produtoService->recuperar(
            'select p.prod_codigo, p.prod_descricao, p.prod_sabor, p.prod_preco,
                p.emb_codigo, e.emb_qtde
            from tb_produto as p
            left join tb_embalagem e on p.emb_codigo = e.emb_codigo
            order by p.prod_descricao');
       

   }
   else if($acao == 'recuperar_lista')
   {
       $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
       $it_pagina = filter_input(INPUT_POST, 'it_pagina', FILTER_SANITIZE_NUMBER_INT);
       $inicio = (($pagina-1)*$it_pagina);
       
       $conexao = new Conexao();

       $produto = new Produto();
       
       $produtoService = new ProdutoService($conexao, $produto);
       $produtos = $produtoService->recuperar(
            'select p.prod_codigo, p.prod_descricao, p.prod_sabor, p.prod_preco,
                p.emb_codigo, e.emb_qtde
            from tb_produto as p
            left join tb_embalagem e on p.emb_codigo = e.emb_codigo
            order by p.prod_descricao
            limit '.$inicio.', '.$it_pagina);
       ?>
            <table class="table table-striped table_bordered">
                <thead>
                    <th>Produto</th>
                    <th>Sabor</th>
                    <th>Preço</th>
                    <th></th>
                </thead>
                <?php foreach($produtos as $produto){
                        if ($produto->emb_codigo == '')
                                $produto->emb_codigo = 0;?>
                        <tr>
                            <div class="col-sm-12" id="produto_<?= $produto->prod_codigo ?>" >
                                <td><?= $produto->prod_descricao ?></td>
                                <td><?= $produto->prod_sabor ?></td>
                                <td>R$ <?= number_format($produto->prod_preco, 2, ',', '.'); ?></td>
                            </div>
                            <td>
                                <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover( <?= $produto->prod_codigo ?>)"></i>
                                <i class="fas fa-edit fa-lg text-info" onclick="editar( <?= $produto->prod_codigo ?>, '<?= $produto->prod_descricao ?>', '<?= $produto->prod_sabor ?>', '<?= number_format($produto->prod_preco, 2, ',', '.');?>', <?= $produto->emb_codigo ?>, <?= $pagina ?>, <?= $it_pagina ?> )"></i> 
                            </td>
                        </tr>
                <?php } ?>
            </table>
            <?php $qtde_registros = $produtoService->qtde_registros();
                  $pagina_final = ceil($qtde_registros/$it_pagina);
                  if($qtde_registros > $it_pagina){?>
                        <div id="pag">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a href="#" onclick='listar_produto(1, <?= $it_pagina?>)' class="page-link"><span>&laquo;</span></a>
                                    </li>

                                    <?php if($pagina > 1) {?>
                                        <li class="page-item">
                                            <a href="#" onclick='listar_produto(<?= ($pagina-1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina-1)?></a>
                                        </li>
                                    <?php }?>

                                    <li class="page-item active">
                                        <a href="#" class="page-link"><?= $pagina?></a>
                                    </li>

                                    <?php if($pagina < $pagina_final) {?>
                                        <li class="page-item">
                                            <a href="#" onclick='listar_produto(<?= ($pagina+1)?>, <?= $it_pagina?>)' class="page-link"><?= ($pagina+1)?></a>
                                        </li>
                                    <?php }?>

                                    <li class="page-item">
                                        <a href="#" onclick='listar_produto(<?= $pagina_final?>, <?= $it_pagina?>)' class="page-link"><span>&raquo;</span></a>
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
       $sabor = filter_input(INPUT_POST, 'sabor');
       $preco = filter_input(INPUT_POST, 'preco');
       $emb_id = filter_input(INPUT_POST, 'emb_id');
       $pagina = filter_input(INPUT_POST, 'pagina');
       $it_pagina = filter_input(INPUT_POST, 'it_pagina');
       
       $conexao = new Conexao();
       $embalagem = new Embalagem();
       
       $embalagemService = new EmbalagemService($conexao, $embalagem);
       $embalagens = $embalagemService->recuperar('select t.emb_codigo,
                t.emb_descricao, t.emb_qtde
            from tb_embalagem as t
            order by t.emb_descricao');
       
       ?> 
        <h4>Editar Cliente</h4>
        <hr />

        <form method="post" action="../controller/produto.controller.php?acao=atualizar">
                <div class="form-group">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <label>Descrição:</label>
                        <input type="text" class="form-control is-valid" name="descricao" required value="<?= $descricao?>">
                        </br>
                        <label>Sabor:</label>
                        <input type="text" class="form-control is-valid" name="sabor" required value="<?= $sabor?>">
                        </br>
                        <label>Preço (R$):</label>
                        <input type="text" id="preco" name="preco" class="form-control is-valid" required onkeypress="$(this).mask('#.##0,00', {reverse: true});" value="<?= $preco?>">
                        </br>
                        <label>Embalagem:</label>
                        <select class="form-select is-valid" name="emb_id" required>
                            <option value="0" selected>Produto sem embalagem</option>
                            <?php foreach($embalagens as $indice => $embalagem){
                                if($emb_id == $embalagem->emb_codigo){?>
                                    <option value="<?= $embalagem->emb_codigo ?>" selected=""><?= $embalagem->emb_descricao?></option>
                                <?php } ?>
                            <?php } ?>
                        </select></br>

                </div>

                <button class="btn btn-success">Atualizar</button>
                <input class="btn btn-danger" type="button" value="Cancelar" onclick="listar_produto(<?= $pagina?>, <?= $it_pagina?>)">
        </form>
       
       <?php
   }
   else if($acao == 'atualizar')
   {
       $produto = new Produto();
       $produto->__set('prod_codigo', $_POST['id']);
       $produto->__set('prod_descricao', $_POST['descricao']);
       $produto->__set('prod_sabor', $_POST['sabor']);
       $preco = $_POST['preco']; 
       $preco = str_replace(',', '.', $preco);
       $produto->__set('prod_preco', $preco);
       $emb_id = $_POST['emb_id'];
        if($emb_id > 0)
            $produto->__set('emb_codigo', $emb_id);
       
       $conexao = new Conexao();
       
       $produtoService = new ProdutoService($conexao, $produto);
       if($produtoService->atualizar()) {
           header('location: ../view/produto.consulta.php');
       }
   }
   else if($acao == 'remover')
   {
       $produto = new Produto();
       $produto->__set('prod_codigo', $_GET['id']);
       
       $conexao = new Conexao();
       
       $produtoService = new ProdutoService($conexao, $produto);
       if($produtoService->remover()) {
	  header('location: ../view/produto.consulta.php');
       }
   }

