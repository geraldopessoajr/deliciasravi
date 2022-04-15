<?php 

    require_once 'validador_acesso.php';

    $acao = 'recuperar';
    require '../controller/produto.controller.php';
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
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
                <script src="./js/status_produto.js"></script>
        </head>

	<body>
            <iframe width="100%" height="120px" src='./html/menu_principal.html'></iframe>
                <? if(isset($_GET['inclusao']) && $_GET['inclusao'] == 1 ) { ?>
                    <div class="bg-success pt-2 text-white d-flex justify-content-center">
                        <h5>Produto inserido com sucesso!</h5>
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
								<h4>Novo Produto</h4>
                                                                <hr />

                                                                <form method="post" action="../controller/produto.controller.php?acao=inserir">
                                                                        <div class="form-group">
                                                                                <label>Descrição:</label>
                                                                                <input type="text" class="form-control is-valid" name="descricao" required>
                                                                                </br>
                                                                                <label>Sabor:</label>
                                                                                <input type="text" class="form-control is-valid" name="sabor" required>
                                                                                </br>
                                                                                <label>Preço (R$):</label>
                                                                                <input type="text" id="preco" name="preco" class="form-control is-valid" required onkeypress="$(this).mask('#.##0,00', {reverse: true});">
                                                                                </br>
                                                                                <label>Embalagem:</label>
                                                                                <select class="form-select is-valid" name="emb_id" required>
                                                                                    <option value="0" selected>Produto sem embalagem</option>
                                                                                    <?php foreach($embalagens as $indice => $embalagem){?>
                                                                                        <option value="<?= $embalagem->emb_codigo ?>"><?= $embalagem->emb_descricao?></option>

                                                                                    <?php } ?>
                                                                                </select></br>

                                                                        </div>

                                                                        <button class="btn btn-success">Cadastrar</button>
                                                                        <input class="btn btn-danger" type="reset" value="Cancelar">
                                                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>