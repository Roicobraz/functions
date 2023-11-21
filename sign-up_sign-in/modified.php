<?php
    require('header.php');

    $conn = serv_init();

    $value = '';
    // if(!empty($_POST["nom"])):
    // {
    //     $nom = $_POST["nom"];
    //     $value .= "nom_contact = ".$nom.",";
    // }
    // endif;

    if(!empty($_POST["prenom"])):
    {
        $prenom = $_POST["prenom"];
        $value .= "prenom_contact = '".$prenom."'";
    }
    endif;

    // if(!empty($_POST["email"])):
    // {
    //     $email = $_POST["email"];
    //     $value .= "email_contact = ".$email.",";
    // }
    // endif;

    // if(!empty($_POST["tel"])):
    // {
    //     $tel = $_POST["tel"];
    //     $value .= "telephone_contact = ".$tel;
    // }
    // endif;

    $query = "SELECT * FROM contact WHERE id_contact = ".$_GET['id_contact'];
    $result = $conn->query($query);

    if ($result) {
        $add = "UPDATE contact SET $value WHERE id_contact=".$_GET['id_contact']; 
        if ($conn->query($add)) :
        {
            echo "Contact modifi&eacute;";
        } else:
        {
            echo "Erreur: " . $add . "<br>" . $conn->error;
        }
        endif;
    } else {
        echo 'Error: ' . mysqli_error();
    }
    $conn->close();
    cstm_footer();
?>