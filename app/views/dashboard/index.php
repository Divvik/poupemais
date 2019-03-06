<?php 	if(!defined('DIRREQ')) exit; ?>
<?php if(isset($_SESSION['idUsuario'])) : ?>
<?php require_once VIEWS . 'includes/header-dashboard.php' ?>
	<div class="container">
		<h1>Login</h1>
		<table id="table-dashboard">
			<thead>
				<th>Nome</th>
				<th>Cpf</th>
				<th>Plano</th>
				<th>Vencimento</th>
				<th>Situacao</th>
				<th>Valor</th>
			</thead>
			<tr>
				<?php foreach ($data as $row) { ?>
					<?php foreach ($row as $linha => $usuario) { ?>
				<td><?= $usuario['nomeCliente']?></td>
				<td><?= $usuario['cpf']?></td>
				<td><?= $usuario['nomePlano']?></td>
				<td>
					<?php 
						$data = $usuario['vencimento'];
						$date = new DateTime($data);
						echo $date->format('d-m-Y'); 
					?>
				</td>
				<td><?= $usuario['situacao']?></td>
				<td>R$<?= $usuario['valorPlano']?></td>
			</tr>
					<?php } ?>	
				<?php } ?>
		</table>
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>
<?php else : ?>
	<a href="<?= DIRPAGE . '/login'?>">Voltar</a>
<?php endif; ?>