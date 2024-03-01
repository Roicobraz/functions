<?php

//require_once(__ROOT__.'/model/users.php');
//require_once(__ROOT__.'/model/equipment.php');

class controlerAccueil {
//propriété
//	private $user;
//méthode

    public function __construct() {
//        $this->user = new user();
    }		
	
	public function accueil() {
        $vue = new Vue("accueil");
        $vue->generer(
            array(
                "conn" => false
        ));
    }
}