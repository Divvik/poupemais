<?php require_once VIEWS . 'includes/header-login.php' ?>
	<div class="container">
		<h1>Login</h1>
		<fieldset>
			<legend>Entrar</legend>
			<form action="<?= DIRPAGE . '/login/run'?>" method="post">
				<label for="login">Login</label>
				<input type="text" name="c_login" id="login"><br/>
				<label for="password">Senha</label>
				<input type="email" name="c_password" id="password"><br/>
				<button type="submit">Entrar</button>
			</form>
		</fieldset>
		<a href="<?= DIRPAGE . '/login/cadastrar'?>">Cadastar</a>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

