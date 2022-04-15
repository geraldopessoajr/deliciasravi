<!DOCTYPE html>
<html>
    
<head>
	<title>Delícias da Ravi</title>
        <link rel="stylesheet" href="css/styleLogin.css">	
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
                                            <img src="./img/logo.jpg" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
                                    <form action="./view/valida_login.php" method="post">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user" value="" placeholder="username">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="senha" class="form-control input_pass" value="" placeholder="senha">
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
                                                <br/>
						<div class="d-flex justify-content-center mt-3 login_container">
                                                    <button type="submit" name="button" class="btn login_btn">Login</button>
                                                </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>