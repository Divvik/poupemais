<?php if(!defined('DIRREQ')) exit; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Dog-developer">
	<meta name="keywords" content="<?= $this->getKeywords()?>">
	<meta name="description" content="<?= $this->getDescription()?>"> 
	<title><?= $this->getTitle()?></title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
	<link rel="stylesheet" href="<?= DIRCSS . 'style.css'; ?>">
	<script src= "<?= DIRJS . 'jquery.js'; ?>"></script>
	<script src= "<?= DIRJS . 'custom.js'; ?>"></script>
</head>
<body class="background-login">