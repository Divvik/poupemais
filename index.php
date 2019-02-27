<?php
	header("Content-Type: text/html; charset=utf-8");
	# Declarando os requires dos arquivos necessarios para inicializacao
	require_once 'src/vendor/autoload.php';
	require_once 'config/config.php';
	if(!defined('DIRREQ')) exit;

	# Declarando o use da classes
	use Src\Core\Routes;

	# Instanciando a classe Routes
	$app = new Routes();
