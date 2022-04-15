<?php require_once 'validador_acesso.php'; 

    if(isset($_GET['pagina']))
    { 
        $pagina = $_GET['pagina'].'.php';
    }
    else
    {
        $pagina = 'apresentacao.html';
    }
?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Delícias da Ravi</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="js/status_home.js"></script>
        </head>

	<body>
		<nav class="navbar">
			<div class="container">
				<a class="navbar-brand" href="home.php">
					<img src="img/logo.png" width="90" height="90" class="d-inline-block align-top" alt="">
				</a>               
                                <ul class="navbar-nav">
                                  <li class="nav-item">
                                    <a href="logoff.php" class="text-white">
                                        SAIR
                                    </a>
                                  </li>
                                </ul>
			</div>
		</nav>
                <? if(isset($_GET['inclusao']) && $_GET['inclusao'] == 1 ) { ?>
                    <div class="bg-success pt-2 text-white d-flex justify-content-center">
                        <h5>Registro inserido com sucesso!</h5>
                    </div>
                <? }?> 
                <div class="container app">
			<div class="row">
				<div class="col-md-3">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header menu" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        Pedidos
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <li id="consultaPedido" class="list-group-item menu2"><a href="home.php?pagina=consultar_pedido">Consultar </a></li>
                                                            <hr/>
                                                            <li id="novoPedido" class="list-group-item menu2"><a href="home.php?pagina=novo_pedido">Novo</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Produtos
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <li id="consultaProduto" class="list-group-item menu2"><a href="home.php?pagina=consultar_produto">Consultar</a></li>
                                                            <hr/>
                                                            <li id="novoProduto" class="list-group-item menu2"><a href="home.php?pagina=novo_produto">Novo</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Clientes
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <li id="consultaCliente" class="list-group-item menu2"><a href="home.php?pagina=consultar_cliente">Consultar</a></li>
                                                            <hr/>
                                                            <li id="novoCliente" class="list-group-item menu2"><a href="home.php?pagina=novo_cliente">Novo</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        Embalagens
                                                    </button>
                                                </h2>
                                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <li id="consultaEmbalagem" class="list-group-item menu2"><a href="home.php?pagina=consultar_embalagem">Consultar</a></li>
                                                            <hr/>
                                                            <li id="novaEmbalagem" class="list-group-item menu2"><a href="home.php?pagina=nova_embalagem">Nova</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                        Usuários
                                                    </button>
                                                </h2>
                                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <?php
                                                                if($_SESSION['perfil_id'] == 1)
                                                                {?>
                                                                    <li id="consultaUsuario" class="list-group-item menu2"><a href="home.php?pagina=consultar_usuario">Consultar</a></li>
                                                                    <hr/>
                                                                    <li id="novoUsuario" class="list-group-item menu2"><a href="home.php?pagina=novo_usuario">Novo</a></li>
                                                                    <hr/>
                                                                <?php }?>
                                                            <li id="novaSenha" class="list-group-item menu2"><a href="home.php?pagina=nova_senha">Redefinir Senha</a></li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div id="pagina" class="col">
                                                            <input id="pag" type="hidden" value="<?= $pagina ?>"> </input> 
							    	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
        <script>
            let pag = document.getElementById('pag').value;
            $('#pagina').load(pag);
        </script>
</html>