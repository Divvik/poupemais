<?php
	header("Content-Type: text/html; charset=utf8");
	# Declarando os requires dos arquivos necessarios para inicializacao
	require_once 'config/config.php';
	require_once DIRREQ . '/helpers/variaveis.php';
	require_once 'src/vendor/autoload.php';
	
	autoloadFunction('filter_input');

	if(!defined('DIRREQ')) exit;

	# Declarando o use da classes
	use Src\Core\Routes;

	# Instanciando a classe Routes
	$app = new Routes();
