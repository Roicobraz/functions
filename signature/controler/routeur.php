<?php
/**
*   Ensemble des controleurs
**/
require_once(__ROOT__.'/controler/controleraccueil.php');
require_once(__ROOT__.'/controler/controleradmin.php');
require_once(__ROOT__.'/controler/controlercustomsignature.php');

require_once(__ROOT__.'/model/model.php');
require_once(__ROOT__.'/view/vue.php');

class Routeur {
    private $ctrlAccueil;
    private $ctrlAdmin;
    private $ctrlCstmsign;

    public function __construct() {
        $this->ctrlAccueil = new ControlerAccueil();
        $this->ctrlAdmin = new controlerAdmin(); 
		$this->ctrlCstmsign = new controlerCstmsign();
    }

    // Route une requête entrante : exécution l'action associée
    public function routerRequete() {
        session_start();
        try {
                if(isset($_GET['action']) /*&& isset($_SESSION['login'])*/)
                {
                    if ($_GET['action'] == 'custom_signature')
					{
						$this->ctrlCstmsign->accueil();
                    }
					elseif ($_GET['action'] == 'admin')
					{
						$this->ctrlAdmin->administrator();
                    }                   
//                    elseif ($_GET['action'] == 'deconnection') {
//                        unset($_SESSION['login']);
//                        unset($_COOKIE['PHPSESSID']);
//                        session_destroy();
//                        $this->ctrlAccueil->accueil();
//                    }
                    else
					{  
						$this->ctrlAccueil->accueil();                    
					}
                }
                else {  // aucune action définie : affichage de l'accueil
                    $this->ctrlAccueil->accueil();
                }
        }
        catch (Exception $e) {
            $this->erreur($e->getMessage());
        }
    }

    // Affiche une erreur
    private function erreur($msgErreur) {
        $vue = new Vue("erreur");
        $vue->generer(array('msgerreur' => $msgErreur));
    }

    // Recherche un paramètre dans un tableau
    private function getParametre($tableau, $nom) {
        if (isset($tableau[$nom])) {
            return $tableau[$nom];
        }
        // else {
        //     throw new Exception("Paramètre '$nom' absent");
		// }
    }

}