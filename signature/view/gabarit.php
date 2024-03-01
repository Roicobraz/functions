<?php require_once(__ROOT__.'/rsc/function.php'); 
if(isset($_SESSION['login'])){
    $account = new user;
    $iduser = $account->getUser($_SESSION['login']);
    $id_right = $iduser[0]['id_right'];
    $priv = $account->getPrivilege($id_right);
}
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo($titre) ?></title>
<!--            <link rel="stylesheet" href="<?= surl("~/")?>rsc/css/style.css">-->
<!--            <script src="<?= surl("~/")?>rsc/js/script.js"></script>-->
            <script src="<?= surl("~/")?>rsc/js/users.js"></script>
<!--            <script src="<?= surl("~/")?>rsc/js/jquery.js"></script>-->
	</head>
	<header>
		<nav>
			<ul class="navigation_bar">
				<li><a href="<?= surl("~/")?>">accueil</a></li>
				<li><a href="<?= surl("~/")?>?action=custom_signature">custom_signature</a></li>
				<li><a href="<?= surl("~/")?>?action=admin">admin</a></li>
	<?php  if(isset($_SESSION['login'])){ ?>

	<?php  } ?>
			</ul>
		</nav>
	</header>
<main>
	<div id="global" class="wrap">
		<div id="contenu">
			<?= $contenu ?>
		</div> <!-- #contenu -->
	</div> <!-- #global -->
</main>
<?php require_once(__ROOT__.'/templates/footer.php') ?>
</html>