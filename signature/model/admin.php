<?php
require_once(__ROOT__.'/model/model.php');
require_once(__ROOT__.'/model/user.php');

/**
* 	class récupérant les templates
**/
class admin extends user{
//propriété
	
//méthode
	/**
	* 	Ajout d'un utilisateur
	**/
	public function setUser($infos)
	{
		$query = $this->executerRequete("INSERT INTO users (nom_user, prenom_user, fonction_user, mail_user, adresse_user, telephone_user) VALUES (:nom, :prenom, :fonction, :mail, :adresse, :telephone)", array('nom' => $infos['nom'], 'prenom' => $infos['prenom'], 'fonction' => $infos['fonction'], 'mail' => $infos['mail'], 'adresse' => $infos['phone'], 'telephone' => $infos['addr']));						
		return($query);
	}
	
	/**
	* 	Récupération des utilisateurs
	**/
	public function getUsers()
	{
		$query = $this->executerRequete("SELECT * FROM users");
		$query = $query->fetchAll();
		return($query);
	}
	
	/**
	* 	Modification d'un utilisateur
	**/
	public function modUser($infos)
	{
		$query = $this->executerRequete("UPDATE users SET nom_user = :nom, prenom_user = :prenom, fonction_user = :fonction, mail_user = :mail, adresse_user = :addr, telephone_user = :phone WHERE id_users = :id;", array('id' => $infos['id'], 'nom' => $infos['nom'], 'prenom' => $infos['prenom'], 'fonction' => $infos['fonction'], 'mail' => $infos['mail'], 'addr' => $infos['addr'], 'phone' => $infos['phone'] ));
		return($query);
	}
	
	/**
	* 	Suppression d'un utilisateur
	**/
	public function supprUser($iduser)
	{
		$this->executerRequete("DELETE FROM users WHERE id_users=:id", array('id' => $iduser));
	}
	
	/**
	* 	Ajout d'avatar
	**/
	public function setAvatar($infos)
	{
		$query = $this->executerRequete("INSERT INTO avatar (url_avatar, id_users, nom_avatar) VALUES (:avatar, :id_user, :name)", array('id_user' => $infos['id_user'], 'avatar' => $infos['avatar'], 'name' => $infos['name']));			
		return($query);
	}
	
	/**
	* 	Récupération des avatars
	**/
	public function getAvatars()
	{
		$query = $this->executerRequete("SELECT * FROM avatar");
		$query = $query->fetchAll();
		return($query);
	}

	/**
	* 	Suppression d'un avatar
	**/
	public function supprAvatar($iduser)
	{
		$this->executerRequete("DELETE FROM avatar WHERE id_avatar=:id", array('id' => $iduser));
	}
}