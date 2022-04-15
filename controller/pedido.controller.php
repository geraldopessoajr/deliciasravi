<?php

   require "../model/pedido.model.php";
   require "../model/cliente.model.php";
   require "../model/produto.model.php";
   require "../model/item_pedido.model.php";
   require "../model/pedido.service.php";
   require "../model/cliente.service.php";
   require "../model/produto.service.php";
   require "../model/item_pedido.service.php";
   require "../model/conexao.php";
   
   $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
   
   if($acao == 'inserir')
   {       
        $pedido = new Pedido();

        $pedido->__set('ped_data_entrega', $_POST['data_entrega']);
        $pedido->__set('ped_hora_entrega', $_POST['hora_entrega']);
        $pedido->__set('cli_codigo', $_POST['cli_id']);
        $pedido->__set('st_codigo', 1); 

        $conexao = new Conexao();
        
        if(!isset($_POST['cliente']))
	{
            	$cliente = new Cliente();

		$cliente->__set('cli_nome', $_POST['nome']);
		$cliente->__set('cli_contato', $_POST['contato']);
		$cliente->__set('cli_endereco', $_POST['endereco']);
		$cliente->__set('cli_referencia', $_POST['referencia']);

		$conexao = new Conexao();


		$clienteService = new ClienteService($conexao, $cliente);
		$clienteService->inserir();

            $codigo = $clienteService->recuperarCodigo();
            $pedido->__set('cli_codigo', $codigo);
	}

        $pedidoService = new PedidoService($conexao, $pedido);
        $pedidoService->inserir();

        
        $qtde_produto = $_POST['qtde_produto'];
        $ped_id = $pedidoService->recuperarCodigo();

        $item_pedido = new Item_Pedido();
        $item_pedidoService = new Item_PedidoService($conexao, $item_pedido);

        for($i=0;$i<$qtde_produto;$i++)
        {
           $codigo = $_POST['produto_'.$i];
           $qtde = $_POST['qtde_'.$i];
           $item_pedidoService->inserir($qtde, $ped_id,$codigo);
           $item_pedidoService->diminuiEmbalagem($qtde, $codigo);
        } 

        header('Location: ../view/pedido.novo.php?inclusao=1');
   }
   else if($acao == 'recuperar')
   {
       $conexao = new Conexao();

       $cliente = new Cliente();
       $clienteService = new ClienteService($conexao, $cliente);
       $clientes = $clienteService->recuperar(
            'select c.cli_codigo, c.cli_nome, c.cli_contato, c.cli_endereco, c.cli_referencia
            from tb_cliente as c 
            order by c.cli_nome');

       $pedido = new Pedido();
       $pedidoService = new PedidoService($conexao, $pedido);

       $sql = '';

       if(isset($_GET['nome']))
       {
          $sql = ' where c.cli_nome like \'%'.$_GET['nome'].'%\'';
       }

       if(isset($_GET['status']))
       {
          if($sql == '')
             $sql = ' where s.st_codigo = '.$_GET['status'];
          else
             $sql = $sql.' and s.st_codigo = '.$_GET['status'];
       }
       
       if(isset($_GET['data_inicial']) && isset($_GET['data_final']))
       {
          if($sql == '')
             $sql = ' where p.ped_data_entrega between \''.$_GET['data_inicial'].'\' and \''.$_GET['data_final'].'\'';
          else
             $sql = $sql.' and p.ped_data_entrega between \''.$_GET['data_inicial'].'\' and \''.$_GET['data_final'].'\'';
       }
       else
       { 
	       if(isset($_GET['data_inicial']))
	       {
		  if($sql == '')
		     $sql = ' where p.ped_data_entrega >= \''.$_GET['data_inicial'].'\'';
		  else
		     $sql = $sql.' and p.ped_data_entrega >= \''.$_GET['data_inicial'].'\'';
	       } 
	       if(isset($_GET['data_final']))
	       {
		  if($sql == '')
		     $sql = ' where p.ped_data_entrega <= \''.$_GET['data_final'].'\'';
		  else
		     $sql = $sql.' and p.ped_data_entrega <= \''.$_GET['data_final'].'\'';
	       }
        } 
       
       if(isset($_GET['hora_inicial']) && isset($_GET['hora_final']))
       {
          if($sql == '')
             $sql = ' where p.ped_hora_entrega between \''.$_GET['hora_inicial'].'\' and \''.$_GET['hora_final'].'\'';
          else
             $sql = $sql.' and p.ped_hora_entrega between \''.$_GET['hora_inicial'].'\' and \''.$_GET['hora_final'].'\'';
       }
       else
       { 
	       if(isset($_GET['hora_inicial']))
	       {
		  if($sql == '')
		     $sql = ' where p.ped_hora_entrega >= \''.$_GET['hora_inicial'].'\'';
		  else
		     $sql = $sql.' and p.ped_hora_entrega >= \''.$_GET['hora_inicial'].'\'';
	       } 
	       if(isset($_GET['hora_final']))
	       {
		  if($sql == '')
		     $sql = ' where p.ped_hora_entrega <= \''.$_GET['hora_final'].'\'';
		  else
		     $sql = $sql.' and p.ped_hora_entrega <= \''.$_GET['hora_final'].'\'';
	       }
        }

       $pedidos = $pedidoService->recuperar($sql);

       foreach($pedidos as $indice => $pedido)
       {
           $item_pedido = new Item_Pedido();
	   $item_pedidoService = new Item_PedidoService($conexao, $item_pedido); 
	   $itens_pedido = $item_pedidoService->recuperar($pedido->ped_codigo);
           $pedido->itens = $itens_pedido;
       }
       
       $produto = new Produto();
       
       $produtoService = new ProdutoService($conexao, $produto);
       $produtos = $produtoService->recuperar(
            'select p.prod_codigo, p.prod_descricao, p.prod_sabor, p.prod_preco,
                p.emb_codigo, e.emb_qtde
            from tb_produto as p
            left join tb_embalagem e on p.emb_codigo = e.emb_codigo
            order by p.prod_descricao');

   }
   else if($acao == 'atualizar')
   {
       $pedido = new Pedido();
       $pedido->__set('ped_codigo', $_POST['id']);
       $pedido->__set('ped_data_entrega', $_POST['data_entrega']);
       $pedido->__set('ped_hora_entrega', $_POST['hora_entrega']);
       
       $conexao = new Conexao();

       $qtde_produto = $_POST['qtde_produto'];
       $ped_id = $pedido->__get('ped_codigo');

       $item_pedido = new Item_Pedido();
       $item_pedidoService = new Item_PedidoService($conexao, $item_pedido);
       
       $itens_pedido = $item_pedidoService->recuperar($ped_id);

       foreach($itens_pedido as $indice => $item_pedido)
       {
           $item_id = $item_pedido->ip_codigo;
           $codigo = $item_pedido->prod_codigo;

           if($item_id != 0)
           {    
                $item_pedidoService->aumentaEmbalagem($item_id, $codigo);
           }

        }
         
        $item_pedidoService->remover($ped_id);

        for($i=0;$i<$qtde_produto;$i++)
        {
           $item_id = $_POST['item_'.$i];
           $codigo = $_POST['produto_'.$i];
           $qtde = $_POST['qtde_'.$i];

           if($item_id == 0)
           {
               $item_pedidoService->inserir($qtde, $ped_id,$codigo);
               $item_pedidoService->diminuiEmbalagem($qtde, $codigo);
           }
           else
           {
               $item_pedidoService->atualizar($item_id, $qtde, $ped_id,$codigo);
               $item_pedidoService->diminuiEmbalagem($qtde, $codigo);
           }

        }
       
       
       $pedidoService = new PedidoService($conexao, $pedido);  

       $url = "";
       $data_entrega = isset($_GET['data_entrega']) ? $_GET['data_entrega'] : '';
       $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
       
       if($data_entrega != '' && $nome != '')
          $url = '?data_entrega='.$data_entrega.'&nome='.$nome;
       else if($data_entrega != '')
          $url = '?data_entrega='.$data_entrega;
       else if($nome != '')
          $url = '?nome='.$nome;
       
       echo $url;
       if($pedidoService->atualizar()) {
           header('location: ../view/pedido.consulta.php?'.$url);
       }
   }
   else if($acao == 'entregar')
   {
       $pedido = new Pedido();
       $pedido->__set('ped_codigo', $_GET['id']);
       
       $conexao = new Conexao();
       
       $pedidoService = new PedidoService($conexao, $pedido);
       if($pedidoService->entregar()) {
           header('location: ../view/pedido.consulta.php?status=1');
       }
   }
   else if($acao == 'remover')
   {
       $pedido = new Pedido();
       $pedido->__set('ped_codigo', $_GET['id']);
       
       $conexao = new Conexao();

       $item_pedido = new Item_Pedido();
       $item_pedidoService = new Item_PedidoService($conexao, $item_pedido); 
       $itens_pedido = $item_pedidoService->recuperar($pedido->__get('ped_codigo'));

       foreach($itens_pedido as $indice => $item_pedido)
       {
           $item_pedidoService->aumentaEmbalagem($item_pedido->ip_codigo, $item_pedido->prod_codigo);
       }
       $pedidoService = new PedidoService($conexao, $pedido);

       $url = "";
       $data_entrega = isset($_GET['data_entrega']) ? $_GET['data_entrega'] : '';
       $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
       
       if($data_entrega != '' && $nome != '')
          $url = '?data_entrega='.$data_entrega.'&nome='.$nome;
       else if($data_entrega != '')
          $url = '?data_entrega='.$data_entrega;
       else if($nome != '')
          $url = '?nome='.$nome;

       if($pedidoService->remover()) {
	  header('location: ../view/pedido.consulta.php?'.$url);
       }
   }

