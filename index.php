<?php
	header("Content-Type: text/html; charset=utf8");
	# Declarando os requires dos arquivos necessarios para inicializacao
	require_once 'config/config.php';
	
	autoloadFunction('filter_input');
	
	include (DIRREQ . '/helpers/variaveis.php');


	require_once DIRREQ . '/src/vendor/autoload.php';

	if(!defined('DIRREQ')) exit;

	# Declarando o use da classes
	use Src\Core\Routes;

	# Instanciando a classe Routes
	$app = new Routes();
