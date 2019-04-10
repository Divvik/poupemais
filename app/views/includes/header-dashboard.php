<?php if(!defined('DIRREQ')) exit; ?>
<?php 
	$session = new \Src\Core\Session();
	$session->verifyInsideSession();
?>
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
<body>
	<header class="header-dashboard">
		<div class="container grid">
			<h1>dashboard</h1>
			<nav>
				<ul>
					<li><?=$_SESSION['name'];?></li>
					<li><a href="<?= DIRPAGE . '/dashboard/logout'?>">logout</a></li>
				</ul>
			</nav>
		</div>
	</header>