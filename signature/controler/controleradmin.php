<?php
require_once(__ROOT__.'/model/admin.php');

class controlerAdmin {
//propriété
	private $admin;
//méthode

    public function __construct() {
        $this->admin = new admin();
    }		
	
/*--------------------------------------------*/
    public function administrator() {
        $users = $this->admin->getUsers();
        $avatar = $this->admin->getAvatars();
        $vue = new Vue("admin");
        $vue->generer(array(
			'users' => $users,
			'avatars' => $avatar
		));
    }
}