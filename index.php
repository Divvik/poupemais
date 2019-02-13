<?php
	# Declarando os requires dos arquivos necessarios para inicializacao
	require_once 'src/vendor/autoload.php';
	require_once 'config/config.php';

	# Declarando o use da classes
	use Src\Core\Routes;

	# Instanciando a classe Routes
	$app = new Routes();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Poupe Mais</title>
</head>
<body>
	<h1>Título</h1>
	<?php
		echo 'LOCALHOST RAIZ: ' . DIRPAGE . '<br/>';
		echo 'DIR RAIZ: ' . DIRREQ . '<br/>';
		echo 'DIR CSS: ' . DIRCSS . '<br/>';
		echo 'DIR JS: ' . DIRJS . '<br/>';
		echo 'DIR IMG: ' . DIRIMG . '<br/>';
	?>
</body>
</html>
