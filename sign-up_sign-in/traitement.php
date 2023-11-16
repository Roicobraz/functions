<?php
    require_once('functions.php');

    $conn = serv_init();

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];

    $sql1 = "INSERT INTO contact (nom_contact,prenom_contact,email_contact,telephone_contact) VALUES ('".$nom."','".$prenom."','".$email."','".$tel."')";
    
    if ($conn->query($sql1) === TRUE ) :
    {
        echo "Nouveau contact ajout&eacute;";
    } 
else:
    {
        echo "Erreur: " . $sql1 . "<br>" . $conn->error;
    }
    endif;

    $conn->close();
?>