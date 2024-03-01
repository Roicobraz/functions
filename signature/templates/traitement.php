<?php
    require_once('../rsc/function.php');
    require_once(__ROOT__.'/model/admin.php');
    session_start();

    /**
    * Connection
    **/
//    if(isset($_POST['user_name']) && isset($_POST['user_pwd']))
//    {
//        $connection = new user();
//        $accountexist = $connection->getUserid($_POST['user_name']);
//        $password = $accountexist[0]['user_password'];
//
//        if(password_verify($_POST['user_pwd'], $password))
//        {
//            //On démarre une nouvelle session
//            session_start();
//            $_SESSION['login'] = $accountexist[0]['id_user'];
//            header("Location: ".surl("~/")."?action=myaccount");
//        }
//        else
//        {
//            header("Location: ".surl("~/")."");
//        }            
//    }
//    elseif(isset($_SESSION['login']))
//    {

        /**
        * Ajout d'utilisateur
        **/
        if(isset($_POST['new_prenom']))
        {
            $admin = new admin();
			$infos = array(
				'nom' => $_POST['new_nom'], 
				'prenom' => $_POST['new_prenom'], 
				'fonction' => $_POST['new_fonction'], 
				'mail' => $_POST['new_mail'], 
				'addr' => $_POST['new_addr'], 
				'phone' => $_POST['new_phone']
			);
            $admin->setUser($infos);
            header("Location: ".surl("~/")."?action=admin");
        }
		/**
        * Modification d'utilisateur
        **/
        elseif(isset($_POST['mod_id']))
        {
            $modified = new admin();
			$infos = array(
				'id' => $_POST['mod_id'], 
				'nom' => $_POST['mod_nom'], 
				'prenom' => $_POST['mod_prenom'], 
				'fonction' => $_POST['mod_fonction'], 
				'mail' => $_POST['mod_mail'], 
				'addr' => $_POST['mod_addr'], 
				'phone' => $_POST['mod_phone']
			);
            $modified->modUser($infos);
            header("Location: ".surl("~/")."?action=admin");
        }
        /**
        * Suppression d'utilisateur
        **/
        elseif(isset($_POST['idusersuppr']))
        {
            $suppr = new admin();
            $suppr->supprUser($_POST['idusersuppr']);
            header("Location: ".surl("~/")."?action=admin");
        }
		/**
        * Ajout d'avatar
        **/
        elseif(isset($_FILES['new_avatar']))
        {
			$structure = 'rsc/img/';
			$uploadfile = '../'.$structure . basename($_FILES['new_avatar']['name']);
			
			if(file_exists('../'.$structure))
			{	
				move_uploaded_file($_FILES['new_avatar']['tmp_name'], $uploadfile);
			}
			else
			{
				if (!mkdir('../'.$structure, 0777, true))
				{
					die('Échec lors de la création des dossiers...');
				}
				move_uploaded_file($_FILES['new_avatar']['tmp_name'], $uploadfile);
			}
						
            $modified = new admin();
			$infos = array(
				'id_user' => $_POST['iduser_avatar'], 
				'name' => $_POST['new_nameavatar'],
				'avatar' => surl("~/").$structure.$_FILES['new_avatar']['name'], 	
			);
            $modified->setAvatar($infos);
            header("Location: ".surl("~/")."?action=admin");
        }
        /**
        * Suppression d'avatar
        **/
        elseif(isset($_POST['']))
        {
            $suppr = new admin();
            $suppr->supprAvatar($_POST['idusersuppr']);
            header("Location: ".surl("~/")."?action=admin");
        } 


//    }
//    else
//    {
//        header("Location: ".surl("~/")."");
//    }
?>