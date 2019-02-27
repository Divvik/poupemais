<?php 	if(!defined('DIRREQ')) exit; ?>

<?php if(isset($_SESSION['id'])) : ?>
<?php require_once VIEWS . 'includes/header-dashboard.php' ?>
	<div class="container">
		<h1>Login</h1>
		<table border="1">
			<thead>
				<td>ID</td>
				<td>NOME</td>
				<td>EMAIL</td>
				<td>LOGIN</td>
			</thead>
			<tr>
				<?php foreach ($data as $usuario) { ?>
				<td><?= $usuario['id'];?></td>
				<td><?= $usuario['nome'];?></td>
				<td><?= $usuario['email'];?></td>
				<td><?= $usuario['login'];?></td>
				<?php } ?>
			</tr>
		</table>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>
<?php else : ?>
	<a href="<?= DIRPAGE . '/login'?>">Voltar</a>
<?php endif; ?>