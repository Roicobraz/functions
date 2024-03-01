<?php 
	require_once(__ROOT__.'/rsc/function.php'); 
	$this->titre = "Admin"; 
?>

<!-- Gestion des utilisateurs -->
<div class='block'>
    <h3>Gestion des utilisateurs</h3>
	<div class="sous_block">
		<h4>Ensemble des utilisateurs</h4>
        <table>
			<thead>
				<tr>
					<td>Pr&eacute;nom</td>
					<td>Nom</td>
					<td>Fonction</td>
					<td>Adresse mail</td>
					<td>Adresse</td>
					<td>T&eacute;l&eacute;phone</td>
				</tr>			
			</thead>
			<tbody>
			<?php 	foreach ($users as $user)
					{ ?>
					<tr id="<?= $user['id_users']?>">
						<td><?= $user['prenom_user']?></td>
						<td><?= $user['nom_user']?></td>
						<td><?= $user['fonction_user']?> </td>
						<td><?= $user['mail_user']?> </td>
						<td><?= $user['adresse_user']?> </td>
						<td><?= $user['telephone_user']?> </td>
					</tr>
			<?php 	}?>
			</tbody>
		</table>
    </div>
    <div class="sous_block">
		<h4>Ajout d'utilisateur</h4>
        <form action="<?= surl("~/")?>templates/traitement.php" method="post">
			<div>
				<input type="text" name="new_prenom" placeholder="Prénom" required>
				<input type="text" name="new_nom" placeholder="Nom" required>
			</div>
			<div><input type="text" name="new_fonction" placeholder="Fonction" required></div>
			<div><input type="text" name="new_addr" placeholder="Adresse"></div>
			<div><input type="tel" name="new_phone" placeholder="N° de téléphone"></div>
			<div><input type="email" name="new_mail" placeholder="Adresse mail"></div>
			<div><input type="submit"></div>
        </form>
    </div>
    <div class="sous_block">
		<h4>Modification d'utilisateur</h4>
        <form action="<?= surl("~/")?>templates/traitement.php" method="post">
			<select id="usermod" name="mod_id">
					<option selected disabled>--Utilisateur--</option>				
			<?php 	foreach ($users as $user)
					{ ?>
					<option value="<?= $user['id_users']?>">
						<?= $user['prenom_user']?> <?= $user['nom_user']?> 
					</option>
			<?php 	}?>
				</select>
			<div>
				<input id="modfname" name="mod_prenom" type="text" placeholder="Prénom">
				<input id="modname" name="mod_nom" type="text" placeholder="Nom">
			</div>
			<div><input id="modfonction" name="mod_fonction" type="text" placeholder="Fonction"></div>
			<div><input id="modaddr" name="mod_addr" type="text" placeholder="Adresse"></div>
			<div><input id="modphone" name="mod_phone" type="tel" placeholder="N° de téléphone"></div>
			<div><input id="modmail" name="mod_mail" type="email" placeholder="Adresse mail"></div>
			<div><input type="submit"></div>
        </form>
    </div>
    <div class="sous_block">
		<h4>Suppression d'utilisateur</h4>
        <form action="<?= surl("~/")?>templates/traitement.php" method="post">
			<div>
				<select name="idusersuppr">
					<option selected disabled>--Utilisateur--</option>	
			<?php 	foreach ($users as $user)
					{ ?>
					<option value="<?= $user['id_users']?>">
						<?= $user['prenom_user']?> <?= $user['nom_user']?>
					</option>
			<?php 	}?>
				</select>
				<input type="submit" value="Supprimer">
			</div>
        </form>
    </div>
</div>
<!-- Gestion des utilisateurs -->

<!-- Gestion des avatars -->


<?php
	$av = array();
	$jsp = array();
	foreach ($avatars as $avatar)
	{ 
		$id = $avatar['id_users'];
		if(!in_array($id, $av))
		{
			array_push($av, $id);
		}
	}
?>
<div><!--<div class="block">-->
	<h3>Gestion des avatars</h3>
	<div class="sous_block">
		<h4>Ensemble des utilisateurs</h4>
        <table id="table_avatar">
			<thead>
				<tr>
					<td>Utilisateur</td>
					<td>Avatar</td>
				</tr>			
			</thead>
			<tbody>	
<?php	foreach ($av as $a)
		{ ?>
				<tr id="<?=$a?>avatar">
					<td><?=$a?></td>
	<?php	foreach ($avatars as $avatar)
			{ 
				if ($avatar['id_users']=== $a)
				{ ?>
					<td id="<?= $avatar['id_avatar']?>"><?= $avatar['nom_avatar']?></td>
					<td><img src="<?= $avatar['url_avatar']?>"></td>
		<?php	}
			} ?>
				</tr>
<?php	} ?>
			</tbody>
		</table>
    </div>
	<div class="sous_block">
		<h4>Ajout d'avatar</h4>
		<form action="<?= surl("~/")?>templates/traitement.php" method="post" enctype="multipart/form-data">
			<div><input type="text" name="new_nameavatar" placeholder="Nom d'avatar" required></div>
			<select name="iduser_avatar">
				<option selected disabled>--Utilisateur--</option>	
		<?php 	foreach ($users as $user)
				{ ?>
				<option value="<?= $user['id_users']?>">
					<?= $user['prenom_user']?> <?= $user['nom_user']?>
				</option>
		<?php 	}?>
			</select>	
			<div>
				<input type="file" id="add_avatar" name="new_avatar"  accept=".jpg, .jpeg, .png, .webp, .svg, .gif"  required>
			</div>
			<div><input type="submit"></div>
		</form>
	</div>
	<div class="sous_block">
		<h4>Suppression d'avatar</h4>
		<form action="<?= surl("~/")?>templates/traitement.php" method="post">
			<div>
				<select id="iduseravatar" name="iduseravatar">
					<option selected disabled>--Utilisateur--</option>	
			<?php 	foreach ($users as $user)
					{ ?>
					<option value="<?= $user['id_users']?>">
						<?= $user['prenom_user']?> <?= $user['nom_user']?>
					</option>
			<?php 	}?>
				</select>
				
				<select id='idavatar' name="idusersuppr">
					<option selected disabled>--Avatar--</option>	
				</select>
				<input type="submit" value="Supprimer">
			</div>
		</form>
	</div>
</div>
<!-- Gestion des avatars -->

<!-- Gestion des templates -->
<div class='block'>
	
</div>
<!-- Gestion des templates -->


<style>
/*
	.block
	{
		display: none;
	}
*/
</style>

<script>
	/**
	* Utilisateurs
	**/
	const selectuser = document.getElementById('usermod');
	const inputfname = document.getElementById('modfname');
	const inputname = document.getElementById('modname');
	const inputfonction = document.getElementById('modfonction');	
	const inputaddr = document.getElementById('modaddr');	
	const inputphone = document.getElementById('modphone');	
	const inputmail = document.getElementById('modmail');	
	selectuser.addEventListener("change", (event) => {
		let index = selectuser.selectedIndex
		let elementactive = selectuser[index].value;
		let text = document.getElementById(elementactive).outerText;
		words = text.split('\t')
		inputfname.value=words[0];
		inputname.value=words[1];
		inputfonction.value=words[2];
		inputmail.value=words[3];
		inputaddr.value=words[4];
		inputphone.value=words[5];
	});
	
	/**
	* Avatar
	**/
	const selectuseravatar = document.getElementById('iduseravatar');
	const selectavatar = document.getElementById('idavatar');
	const table_avatar = document.getElementById('table_avatar');
	
	selectuseravatar.addEventListener("change", (event) => {
		let index = selectuseravatar.selectedIndex;
		let elementactive = selectuseravatar[index].value;
		let td = document.getElementById(elementactive+"avatar").children;
		for (let element of td) {
			if (element != td[0] && element.attributes.id)
			{
				opt = document.createElement("option");
				opt.value = element.attributes.id.value;
				opt.text = element.attributes.id.ownerElement.innerText;
				selectavatar.add(opt, selectavatar.options[1]);
			}
		};
	});
</script>