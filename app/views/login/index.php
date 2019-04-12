<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'login/header.php' ?>
	<main class="fundo">
		<div class="container">
			<h1 class="titulo-login">Login</h1>
			<form id="form-login" action="<?= DIRPAGE . '/login/validaUsers'?>" method="post">
				<p class="caps-lock"></p>
				<input type="text" name="c_login" id="login" placeholder = "login"><br/>
				<input type="password" name="c_password" id="password" placeholder = "password"><br/>
				<!-- <input type="hidden" name="c_g-recaptcha-response" id="g-recaptcha-response"> -->
				<a class="nova-senha" href="<?= DIRPAGE . 'login/novasenha'?>">Esqueci minha senha.</a>
				<a class="login-cadastre" href="<?= DIRPAGE . '/cadastro'?>">Cadastre-se</a>
				<button class="btn btn-login-enviar" type="submit">Entrar</button>
			</form>
			<!-- <div class="fa-3x"></div> -->
				<p class="alert erro"></p>
				<p class="alert retorno"></p>
		</div>
	</main>
<?php require_once  VIEWS . 'includes/footer.php' ?>

