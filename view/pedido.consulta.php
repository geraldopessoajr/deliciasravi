<?php 
    require_once 'validador_acesso.php';
    
    $acao = 'recuperar';
    $tipo = 1;
    
    $itens_pagina = 3;
    $pagina = 1;
    if(isset($_GET['pagina']))
         $pagina = $_GET['pagina'];
    
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : '';
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : '';
    $hora_inicial = isset($_GET['hora_inicial']) ? $_GET['hora_inicial'] : '';
    $hora_final = isset($_GET['hora_final']) ? $_GET['hora_final'] : '';
        
       
    require '../controller/pedido.controller.php';
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Delícias da Ravi</title>

		<link rel="stylesheet" href="./css/estilo.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
                <script src="./js/pedido.consulta.js"></script> 
        </head>

	<body>
            <iframe width="100%" height="120px" src='./html/menu_principal.html'></iframe>
                <div class="container app">
			<div class="row">
				<div class="col-md-3">
                                    <iframe width="100%" height="500px" src='./html/menu_lateral.html'></iframe>   
                                </div>
                                <div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Pedidos</h4>
                                                                <hr />
                                                                <form>
                                                                    <div id="pesquisa" class="form-group">
                                                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Cliente">
                                                                        <br/>
                                                                        <div class="input-group">
                                                                            <input type="date" class="form-control" id="data_entrega_inicial" name="data_entrega_inicial">
                                                                            <input type="date" class="form-control" id="data_entrega_final" name="data_entrega_final">
                                                                            <div>
                                                                                <input type="time" class="form-control" id="hora_entrega_inicial" name="hora_entrega_inicial">
                                                                            </div>
                                                                            <div>
                                                                                <input type="time" class="form-control" id="hora_entrega_final" name="hora_entrega_final">
                                                                            </div>

                                                                            <div>
                                                                                <select class="form-select" id="status" name="status">
                                                                                    <option value="1" selected>Pendente</option>
                                                                                    <option value="2">Concluído</option>
                                                                                    <option value="0">Todos</option>

                                                                                </select>
                                                                            </div>
                                                                            <input class="btn btn-outline-danger" type="reset" value="Cancelar">
                                                                            <button id="pesq" type="button" class="btn btn-outline-success" onclick="pesquisar();">Pesquisar</button>

                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                </form>
                                                                    <table class="table table-hover table_bordered">
                                                                        <thead>
                                                                            <th>Nome</th>
                                                                            <th>Endereco</th>
                                                                            <th>Contato</th>
                                                                            <th>Data Entrega</th>
                                                                            <th>Horário Entrega</th>
                                                                            <th></th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php usort(

                                                                                $pedidos,

                                                                                    function($a,$b) {

                                                                                        $date1 = $a->ped_data_entrega.' '.$a->ped_hora_entrega;
                                                                                        $date2 = $b->ped_data_entrega.' '.$b->ped_hora_entrega;

                                                                                        if( $date1 == $date2) return 0;

                                                                                            return(($date1 < $date2)?-1:1);
                                                                                        }
                                                                                    );
                                                                            $f = 0;
                                                                            if(($pagina*$itens_pagina) < sizeof($pedidos))
                                                                            {
                                                                                $f = ($pagina*$itens_pagina);
                                                                            }else
                                                                            {
                                                                                $f = sizeof($pedidos);
                                                                            }
                                                                            //foreach($pedidos as $indice => $pedido){
                                                                            for($i=(($pagina*$itens_pagina)-$itens_pagina); $i<$f;$i++){
                                                                                $pedido = $pedidos[$i];?>
                                                                            <tr class="table-danger">
                                                                                <!--<div class="row mb-3 d-flex align-items-center tarefa">-->
                                                                                        <div class="col-sm-12" id="pedido_<?= $pedido->ped_codigo ?>">
                                                                                            <td><?= $pedido->cli_nome ?></td>
                                                                                            <td><?= $pedido->cli_endereco?></td>
                                                                                            <td><?= $pedido->cli_contato?></td>
                                                                                            <td><?= date("d/m/Y", strtotime($pedido->ped_data_entrega)) ?></td>
                                                                                            <td><?= date("H:i", strtotime($pedido->ped_hora_entrega)) ?></td> 
                                                                                        </div>
                                                                                        <td>
                                                                                        <div class="col-sm-3 mt-2 d-flex justify-content-between">
                                                                                                <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover( <?= $pedido->ped_codigo ?>, 1 )"></i>
                                                                                                <?php if($pedido->st_codigo == 1) { ?>
                                                                                                    <i class="fas fa-edit fa-lg text-info" onclick="editar( <?= $pedido->ped_codigo ?>, '<?= $pedido->cli_nome ?>', '<?= $pedido->ped_data_entrega ?>', '<?= date("H:i", strtotime($pedido->ped_hora_entrega)) ?>', chamaProduto(), chamaItens(<?= $pedido->ped_codigo ?>), 1 )"></i>
                                                                                                    <i class="fas fa-check-square fa-lg text-success" onclick="pedidoentregue( <?= $pedido->ped_codigo ?>)"></i>
                                                                                                <?php } ?> 
                                                                                        </div>
                                                                                        </td>
                                                                                <!--</div>-->
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="6">
                                                                                    <table class="table table-borderless">
                                                                                        <tbody>
                                                                                            <?php 
                                                                                               $total = 0;
                                                                                               foreach ($pedido->itens as $key => $item)
                                                                                               { ?>
                                                                                            <tr>
                                                                                                <td><?= $item->ip_qtde ?></td>
                                                                                                <td><?= $item->prod_descricao." - ".$item->prod_sabor ?></td>
                                                                                                <td align="right">R$ <?= number_format((float)$item->prod_preco * $item->ip_qtde, 2, ',', '.'); ?></td>
                                                                                            </tr>
                                                                                            <?php $total += ((float)$item->prod_preco * $item->ip_qtde); } ?>
                                                                                        </tbody>
                                                                                        <tfoot>
                                                                                            <tr>
                                                                                                <td colspan="2">
                                                                                                    <strong>Valor Total</strong>
                                                                                                </td>
                                                                                                <td align="right"><strong> R$ <?= number_format($total, 2, ',', '.'); ?></strong></td>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }  ?>
                                                                    </tbody>
                                                                </table>
                                                                <div id="pag" style="display:none">
                                                                    <nav>
                                                                        <ul class="pagination justify-content-center">
                                                                            <li id="li_1" class="page-item">
                                                                                <a id="a_1" href="" class="page-link"><span>&laquo;</span></a>
                                                                            </li>

                                                                            <div id="first" style="display:none">
                                                                                <li class="page-item">
                                                                                    <a id="a_2" href="" class="page-link">0</a>
                                                                                </li>
                                                                            </div>

                                                                            <li class="page-item active">
                                                                                <a id="a_3" href="" class="page-link">1</a>
                                                                            </li>

                                                                            <div id="second" style="display:block">
                                                                                <li class="page-item">
                                                                                    <a id="a_4" href="" class="page-link">2</a>
                                                                                </li>
                                                                            </div>

                                                                            <li id="li_5" class="page-item">
                                                                                <a id="a_5" href="" class="page-link"><span>&raquo;</span></a>
                                                                            </li>
                                                                        </ul>
                                                                    </nav>
                                                                </div>
                                                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
        <script>
            
            verificaPesquisa();
            
            function verificaPesquisa(){
                var nome = "<?php echo $nome; ?>";
                var status= "<?php echo $status; ?>";
                var data_inicial = "<?php echo $data_inicial; ?>";
                var data_final= "<?php echo $data_final; ?>"; 
                var hora_inicial = "<?php echo $hora_inicial; ?>";
                var hora_final= "<?php echo $hora_final; ?>"; 
                
                if(nome != '')
                   document.getElementById("nome").value = nome;
                if(status != '')
                   document.getElementById("status").value = status;
                if(data_inicial != '')
                   document.getElementById("data_entrega_inicial").value = data_inicial;
                if(data_final != '')
                   document.getElementById("data_entrega_final").value = data_final;
                if(hora_inicial != '')
                   document.getElementById("hora_entrega_inicial").value = hora_inicial;
                if(hora_final != '')
                   document.getElementById("hora_entrega_final").value = hora_final;
            }
            
            function chamaProduto(){
                produtos = Array();
                produtos[0] = Array();
                produtos[1] = Array();
                produtos[2] = Array();
                produtos[3] = Array();    
                var i = 0;
                
                <?php foreach ($produtos as $key => $produto)
                { ?>
                    produtos[0][i]  = "<?php echo $produto->prod_codigo; ?>";  
                    produtos[1][i] = "<?php echo $produto->prod_descricao." - ".$produto->prod_sabor; ?>";
                    produtos[2][i] = "<?php echo $produto->emb_qtde; ?>";
                    produtos[3][i++] = "<?php echo $produto->prod_preco; ?>";
                <?php } ?>
                //return produtos;
            }
            
            function chamaItens(ped_id){
                
                itens = new Array();
                
                <?php foreach($pedidos as $key=> $pedido)
                {?>
                    var ped_codigo = <?php echo $pedido->ped_codigo; ?>;
                    if(ped_codigo == ped_id)
                    {
                        <?php foreach($pedido->itens as $indice=>$ped_itens)
                        {?>
                           var item = new Object();
                           item.item_id = "<?php echo $ped_itens->ip_codigo;?>";
                           item.id = "<?php echo $ped_itens->prod_codigo;?>";
                           item.produto = "<?php echo $ped_itens->prod_descricao." - ".$ped_itens->prod_sabor; ?>";
                           item.qtde = "<?php echo $ped_itens->ip_qtde; ?>";
                           item.preco = "<?php echo $ped_itens->prod_preco; ?>";
                           itens.push(item); 
                        <?php } ?> 
                    }
                      
               <?php }?>
            }
            
            
            function verificaData(){
                let data_entrega = document.getElementById("data_entrega").value;
                
                var data = new Date();
                var dia = String(data.getDate()).padStart(2, '0');
                var mes = String(data.getMonth() + 1).padStart(2, '0');
                var ano = data.getFullYear();
                dataAtual = ano +  '-'+ mes + '-' + dia;
                
                if(data_entrega < dataAtual)
                  document.getElementById("data_entrega").value = dataAtual;
            }
            
            var it_pagina = 10;
            var pagina = 1;
            
            $(document).ready(function() {
                listar_pedido(pagina, it_pagina);
            })
            
            function listar_pedido(pagina, it_pagina)
            {
                $.post('pedido_controller.php', {acao:'recuperar', it_pagina:it_pagina, pagina:pagina}, function(table){
                    $("#tabela").html(table);
                })
            }
        </script>
</html>