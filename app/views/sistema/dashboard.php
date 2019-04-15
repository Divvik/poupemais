<?php 	if(!defined('DIRREQ')) exit; ?>
<?php if(isset($_SESSION['idUsuario'])) : ?>
<?php require_once VIEWS . 'admin/header.php' ?>
	<div class="container">
        <h1>Admin</h1>
        <a href="<?= DIRPAGE .'/admin/cadastrar'?>">Cadastrar</a>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>
<?php else : ?>
	<a href="<?= DIRPAGE . '/login'?>">Voltar</a>
<?php endif; ?>