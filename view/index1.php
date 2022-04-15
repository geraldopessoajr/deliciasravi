<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Delícias da Ravi</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                
                <style>
                    .card-login {
                      padding: 30px 0 0 0;
                      width: 350px;
                      margin: 0 auto;
                    }
                    .navbar{   
                        background-color: #ffc0cb;
                    }
                    .app {
                            margin-top: 25px;
                    }
                    .card-header {
                        background-color: #ffc0cb;
                    }
                </style>
        </head>

	<body>
		<nav class="navbar navbar-dark">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="90" height="90" class="d-inline-block align-top" alt="">
				</a>
			</div>
		</nav>

		<div class="container app">
                    <div class="row">
                        <div class="card-login">
                            <div class="card">
                                <div class="card-header">
                                  Login
                                </div>
                                <div class="card-body">
                                  <form action="valida_login.php" method="post">
                                    <div class="form-group">
                                      <input name="username" type="text" class="form-control" placeholder="Login">
                                    </div>
                                    <div class="form-group">
                                      <input name="senha" type="password" class="form-control" placeholder="Senha">
                                    </div>
                                    <?php if(isset($_GET['login']) && $_GET['login'] == 'erro'){ ?> 
                                      <div class="text-danger">
                                          Usuário ou Senha inválido(s)
                                      </div>

                                    <?php } ?>

                                    <?php if(isset($_GET['login']) && $_GET['login'] == 'erro2'){ ?> 
                                      <div class="text-danger">
                                          Favor realizar Login
                                      </div>

                                    <?php } ?>    

                                    <button id="entrar" class="btn btn-lg btn-success btn-block" type="submit">Entrar</button>
                                  </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
	</body>
</html>