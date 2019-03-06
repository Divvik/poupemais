<?php
	header("Content-Type: text/html; charset=iso-8859-1");
	# Declarando os requires dos arquivos necessarios para inicializacao
	require_once 'src/vendor/autoload.php';
	require_once 'config/config.php';
	autoloadFunction('filter_input');
	

	if(!defined('DIRREQ')) exit;

	# Declarando o use da classes
	use Src\Core\Routes;

	# Instanciando a classe Routes
	$app = new Routes();
