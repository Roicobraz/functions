<?php 

$this->titre = "Accueil"; ?>

<div class="sign_in">
    <div class="container_logo">
        <a href="<?= surl('~/')?>?action=accueil" alt="logo"><img src="<?= surl('~/')?>/rsc/images/aftec.png" alt="logo"></a> 
    </div>

    <div id="connection"> 
        <h2>Se connecter</h2>
        <form action="<?= surl('~/')?>/templates/traitement.php" method="post">
            <label class="information_class" for="user_name">Identifiant</label>
            <input id="user_name" name="user_name" type="text" placeholder="adresse mail">
            <label class="information_class" for="user_pwd">Mot de passe</label>
            <input id="user_pwd" name="user_pwd" type="password" placeholder="Mot de passe">
            <a href="<?= surl('~/')?>?action=mdpoublie">Mot de passe oublié?</a>
            <input type="submit" value="Entrer">
        </form>
    </div>
</div>