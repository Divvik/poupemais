<?php if(!defined('DIRREQ')) exit; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Dashboard - Poupemais</title>
	<link rel="stylesheet" href="<?= DIRCSS . 'style.css'; ?>">
	<script src= "<?= DIRJS . 'jquery.js'; ?>"></script>
	<script src= "<?= DIRJS . 'custom.js'; ?>"></script>
</head>
<body>
	<header class="header-dashboard">
		<div class="container grid">
			<h1>dashboard</h1>
			<nav>
				<ul>
					<li><?=$_SESSION['login'];?></li>
					<li><a href="<?= DIRPAGE . '/login/logout'?>">logout</a></li>
				</ul>
			</nav>
		</div>
	</header>