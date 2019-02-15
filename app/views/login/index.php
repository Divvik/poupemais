<?php require_once VIEWS . 'includes/header.php' ?>
	<div class="container">
		<h1>Login</h1>
			<form action="<?= DIRPAGE . '/login/validaUsers'?>" method="post">
				<label for="login">Login</label>
				<input type="text" name="c_login" id="login"><br/>
				<label for="password">Senha</label>
				<input type="password" name="c_password" id="password"><br/>
				<button type="submit">Entrar</button>
			</form>
		<a href="<?= DIRPAGE . '/login/cadastrar'?>">Cadastar</a>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>

