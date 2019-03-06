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

	<link rel="stylesheet" href="<?= DIRCSS . 'style.css'; ?>">
	<script src= "<?= DIRJS . 'jquery.js'; ?>"></script>
	<script src= "<?= DIRJS . 'custom.js'; ?>"></script>
</head>
<body>
	<header>
		<div class="container grid">
			<a href="<?= DIRPAGE . '/home/index/'?>"><h1 class="logo">Logo</h1></a>
		</div>
	</header>