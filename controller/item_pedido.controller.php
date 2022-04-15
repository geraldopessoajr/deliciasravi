<?php

   require "../model/produto.model.php";
   require "../model/embalagem.model.php";
   require "../model/produto.service.php";
   require "../model/embalagem.service.php";
   require "../model/conexao.php";
   
   $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
   
   if($acao == 'inserir')
   {
        $produto = new Produto();

        $produto->__set('prod_descricao', $_POST['descricao']);
        $produto->__set('prod_sabor', $_POST['sabor']);
        $produto->__set('prod_preco', $_POST['preco']);
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
       $embalagens = $embalagemService->recuperar();

       $produto = new Produto();
       
       $produtoService = new ProdutoService($conexao, $produto);
       $produtos = $produtoService->recuperar();
       

   }
   else if($acao == 'atualizar')
   {
       $produto = new Produto();
       $produto->__set('prod_codigo', $_POST['id']);
       $produto->__set('prod_descricao', $_POST['descricao']);
       $produto->__set('prod_sabor', $_POST['sabor']);
       $produto->__set('prod_preco', $_POST['preco']);
       $produto->__set('emb_codigo', $_POST['emb_id']);
       
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

