<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header.php' ?>
	<main class="fundo">
		<div class="container">
			<h1 class="titulo-login">Login</h1>
			<form class="form-login" action="<?= DIRPAGE . '/login/validaUsers'?>" method="post">
				<label for="login" class="label-login">Login</label>
				<input type="text" name="c_login" id="login"><br/>
				<label for="password" class="label-login">Senha</label>
				<input type="password" name="c_password" id="password"><br/>
				<a class="nova-senha" href="<?= DIRPAGE . 'login/novasenha'?>">Esqueci minha senha.</a>
				<button class="btn btn-login-enviar" type="submit">Entrar</button>
			</form>
		</div>
	</main>
<?php require_once  VIEWS . 'includes/footer.php' ?>

