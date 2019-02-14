<?php

// Caminhos absolutos
$pastaInterna = "";

// Definindo as constantes
define('DIRPAGE', "http://{$_SERVER['HTTP_HOST']}/poupemais{$pastaInterna}");

(substr($_SERVER['DOCUMENT_ROOT'],-1) == '/') ? $barra ="" : $barra = "/"; 
define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}/poupemais{$barra}{$pastaInterna}");

// Atalhos
define('DS', DIRECTORY_SEPARATOR);

// Diretorio assets
define('DIRCSS', DIRPAGE . '/public/assets/css/');
define('DIRJS', DIRPAGE . '/public/assets/js/');
define('DIRIMG', DIRPAGE . '/public/assets/img/');

// Pastas do diretorio App
define('CONTROLLERS', DIRREQ . 'app/controllers/');
define('MODELS', DIRREQ . 'app/models/');
define('VIEWS', DIRREQ . 'app/views/');

// Acesso DB
define('HOST_NAME', 'localhost');
define('DB_NAME', 'db_poupemais');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('CHAR_SET', 'utf8');