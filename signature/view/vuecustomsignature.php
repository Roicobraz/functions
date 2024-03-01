<?php 

$this->titre = "Personnalisation de signature"; ?>

<div>
	<form>
		<input type="text" placeholder="Prénom">
		<input type="text" placeholder="Nom">
		<input type="text" placeholder="Fonction">
		<input type="text" placeholder="Adresse">
		<input type="text" placeholder="N° de téléphone">
		<input type="text" placeholder="Adresse mail">
		<textarea placeholder="Commentaire"></textarea>
		<select>
			<option selected disabled>--Template--</option>	
		</select>
		<input type="submit">
	</form>
	<form>
		<select>
			<option selected disabled>--Utilisateur--</option>	
		</select>
		<select>
			<option selected disabled>--Template--</option>	
		</select>
		<textarea placeholder="Commentaire"></textarea>
		<input type="submit">
	</form>
</div>

<div id="visualisation">
	
</div>