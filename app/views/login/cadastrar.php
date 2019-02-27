<?php if(!defined('DIRREQ')) exit; ?>

<?php require_once VIEWS . 'includes/header-login.php' ?>
	<div class="container">
		<h1>Cadastrar</h1>
		<fieldset>
			<legend>Cadastrar</legend>
			<form action="#" method="post">
				<label for="login">Login</label>
				<input type="text" name="c_login" id="login"><br/>
				<label for="email">Email</label>
				<input type="email" name="c_email" id="email"><br/>
				<button type="submit">Enviar</button>
			</form>
		</fieldset>
		<a href="<?= DIRPAGE . '/login/index'?>">Voltar</a>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

