<?php require_once 'validador_acesso.php'; ?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Delícias da Ravi</title>

		<link rel="stylesheet" href="./css/estilo.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>

	<body>
            <iframe width="100%" height="120px" src='./html/menu_principal.html'></iframe>
                <? if(isset($_GET['inclusao']) && $_GET['inclusao'] == 1 ) { ?>
                    <div class="bg-success pt-2 text-white d-flex justify-content-center">
                        <h5>Cliente inserido com sucesso!</h5>
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
                                                            
								<h4>Novo Cliente</h4>
                                                                <hr />

                                                                <form method="post" action="../controller/cliente.controller.php?acao=inserir">
                                                                        <div class="form-group">
                                                                                <label>Nome:</label>
                                                                                <input type="text" class="form-control is-valid" name="nome" required>
                                                                                </br>
                                                                                <label>Contato:</label>
                                                                                <input type="text" class="form-control is-valid" name="contato" required>
                                                                                </br>
                                                                                <label>Endereço:</label>
                                                                                <input type="text" class="form-control is-valid" name="endereco" required>
                                                                                </br>
                                                                                <label>Ponto de Referência:</label>
                                                                                <input type="text" class="form-control" name="referencia">
                                                                        </div></br>

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