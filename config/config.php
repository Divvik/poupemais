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
define('DIRCSS', DIRREQ . 'public/assets/css/');
define('DIRJS', DIRREQ . 'public/assets/js/');
define('DIRIMG', DIRPAGE . '/public/assets/img/');

// Pastas do diretorio App
define('CONTROLLERS', DIRREQ . 'app/controllers/');
define('MODELS', DIRREQ . 'app/models/');
define('VIEWS', DIRREQ . 'app/views/');

define('LAYOUTERROR', DIRREQ . 'app/views/404Error/404.phtml');

// Acesso DB
define('HOST_NAME', 'localhost');
define('DB_NAME', 'poupemais');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('CHAR_SET', 'utf8');