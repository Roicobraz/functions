<?php
    require('header.php');

    $conn = serv_init();

    if(!empty($_GET['id_contact'])):
    {
        $sql1 = "DELETE FROM contact WHERE id_contact = ".$_GET['id_contact'];

        if ($resultat = $conn->query($sql1) ) 
        {
            echo ('Suppression de l\'utilisateur réussi');
        } 
        else
        {
            echo "Erreur: " . $sql1 . "<br>" . $conn->error;
        }
        $conn->close();
    }
    endif;   
?>