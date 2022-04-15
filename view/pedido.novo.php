<?php
   
    require_once 'validador_acesso.php'; 

    $acao = 'recuperar';
    $tipo = 1;
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
                <script src="./js/status_pedido.js"></script>
        </head>

	<body>
            <iframe width="100%" height="120px" src='./html/menu_principal.html'></iframe>
                <? if(isset($_GET['inclusao']) && $_GET['inclusao'] == 1 ) { ?>
                    <div class="bg-success pt-2 text-white d-flex justify-content-center">
                        <h5>Pedido inserido com sucesso!</h5>
                    </div>
                <? }?>
                <div class="container app">
			<div class="row">
				<div class="col-md-3">
                                    <iframe width="100%" height="500px" src='./html/menu_lateral.html'></iframe>   
                                </div>
                                <div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Novo Pedido</h4>
                                                                <hr />

                                                                <form method="post" action="../controller/pedido.controller.php?acao=inserir">
                                                                        <div class="form-group">

                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" value="cliente" name="cliente" id="cliente" onclick="alteraDiv();">
                                                                                    <label class="form-check-label" for="flexCheckChecked">
                                                                                      Cliente Cadastrado
                                                                                    </label>
                                                                                </div></br>

                                                                                <div id="novo_cliente">
                                                                                    <label>Nome:</label>
                                                                                    <input type="text" class="form-control is-valid" id="nome" name="nome" required>
                                                                                    </br>
                                                                                    <label>Contato:</label>
                                                                                    <input type="text" class="form-control is-valid" id="contato" name="contato" required>
                                                                                    </br>
                                                                                    <label>Endereço:</label>
                                                                                    <input type="text" class="form-control is-valid" id="endereco" name="endereco" required>
                                                                                    </br>
                                                                                    <label>Ponto de Referência:</label>
                                                                                    <input type="text" class="form-control" name="referencia">
                                                                                </div>

                                                                                <div id="seleciona_cliente" style="display:none">
                                                                                    <select class="form-select" name="cli_id" id="cli_id">
                                                                                        <option value="" selected>Selecionar Cliente</option>
                                                                                        <?php foreach($clientes as $indice => $cliente){?>
                                                                                            <option value="<?= $cliente->cli_codigo ?>"><?= $cliente->cli_nome?></option>

                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                </br>

                                                                                Entrega:
                                                                                <div class="input-group">
                                                                                    <input type="date" class="form-control" id="data_entrega" name="data_entrega" placeholder="data" value="<?php echo date('Y-m-d');?>" required="true" onchange="verificaData()">
                                                                                    <input type="time" class="form-control" name="hora_entrega" placeholder="horário" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('H:i');?>" required="true">

                                                                                </div>
                                                                                </br>
                                                                                Produto(s):
                                                                                <div id="produtos">
                                                                                    <div class="input-group">
                                                                                        <select class="form-select" name="prod_id" id="prod_id" required="true">
                                                                                                <option value="" selected>Produtos</option>
                                                                                                <?php foreach($produtos as $indice => $produto){?>
                                                                                                    <option value="<?= $produto->prod_codigo ?>"><?= $produto->prod_descricao?> - <?= $produto->prod_sabor?> </option>

                                                                                                <?php } ?>
                                                                                        </select></br>

                                                                                        <input type="number" class="form-control" id="qtde" name="qtde" min="1" placeholder="Quantidade" required="true">
                                                                                        <button id="add_1" type="button" class="btn btn-outline-success" onclick="adiciona_produto();">Adicionar</button>

                                                                                    </div></br>
                                                                                    <div id="divtabela" class="table-responsive" style="display:none">

                                                                                    </div>
                                                                                </div></br>



                                                                        </div>

                                                                        <button class="btn btn-success" onclick="valida()">Cadastrar</button>
                                                                        <input class="btn btn-danger" type="reset" value="Cancelar" onclick="limpaTabela()">
                                                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
        <script>
            
            chamaProduto();
            
            function alteraDiv()
            {
                let cb = document.getElementById("cliente");
                let div_mostra;
                let div_esconde;
                if(cb.checked)
                {
                    div_mostra = document.getElementById("seleciona_cliente");
                    div_esconde = document.getElementById("novo_cliente");
                    document.getElementById("nome").required = false;
                    document.getElementById("contato").required = false;
                    document.getElementById("endereco").required = false;
                    document.getElementById("cli_id").required = true;
                }
                else
                {
                    div_esconde = document.getElementById("seleciona_cliente");
                    div_mostra = document.getElementById("novo_cliente");
                    document.getElementById("nome").required = true;
                    document.getElementById("contato").required = true;
                    document.getElementById("endereco").required = true;
                    document.getElementById("cli_id").required = false;
                }
                div_mostra.style.display = "block";
                div_esconde.style.display = "none";

            }
            function valida(){
                if(itens.length == 0)
                {
                    document.getElementById("prod_id").value="";
                    document.getElementById("qtde").value="";
                }
            }
            function limpaTabela(){
                itens = new Array(); 
                preenche_produto();
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
            
        </script>
</html>