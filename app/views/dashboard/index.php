<?php 	if(!defined('DIRREQ')) exit; ?>

<?php 
	$session = new \Src\Core\Session();
	$session->verifyInsideSession();
?>

<?php require_once VIEWS . 'includes/header-dashboard.php' ?>
	<div class="container">
		<h1>Login</h1>
		<?php if($data['usuario'] > 0) :?>
			<table id="table-dashboard">
				<thead>
					<th>Nº Invest</th>
					<th>Contratação</th>
					<th>Parcelas</th>
					<th>Vencimento</th>
					<th>Valor</th>
					<th>Data Pagamento</th>
					<th>Situacao</th>
					<th>Plano</th>
					<th>Grupo</th>
				</thead>
				<tr>
					<?php foreach ($data as $row) { ?>
						<?php foreach ($row as $linha => $usuario) { ?>
					<td><?= $usuario['nº_investimento']?></td>
					<td>
						<?php
							$data = $usuario['contratacao'];
							$date = new DateTime($data);
							echo $date->format('d/m/Y'); 
						?>
					</td>
					<td><?= $usuario['parcela']?></td>
					<td><?php 
							$data = $usuario['dt_vencimento'];
							$date = new DateTime($data);
							echo $date->format('d/m/Y'); 
						?>
					</td>
					<td><?= $usuario['valor']?></td>
					<td><?= $usuario['data_pagamento']?></td>
					<td><?= $usuario['situacao']?></td>
					<td><?= $usuario['plano']?></td>
					<td><?= $usuario['grupo']?></td>
				</tr>
						<?php } ?>	
					<?php } ?>
			</table>
		<?php else :?>
			<p>Não existe registro!</p>
		<?php endif;?>
		<!-- <form action="" method="post">
			<select name="plano" id="">
				<option value="">Escolha um plano</option>
			</select>
			<button type="submit">Adquirir</button>
		</form>	
		<a href="#">Adquirir plano</a> -->
	</div>
<?php require_once  VIEWS . 'includes/footer.php' ?>