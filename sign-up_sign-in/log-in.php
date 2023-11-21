<?php
    require_once('functions.php');
    echo(cstm_header());

    $conn = serv_init();

    if(!empty($_GET['id_contact'])):
    {
        $sql1 = "SELECT prenom_contact, nom_contact, email_contact, telephone_contact FROM contact WHERE id_contact = ".$_GET['id_contact'];

        if ($resultat = $conn->query($sql1) ) 
        {
            if($resultat->num_rows > 0) {
                echo('<ul>');
                while ($ligne = $resultat->fetch_assoc()) {
                    echo "<li>" . $ligne["prenom_contact"] . " - " . $ligne["nom_contact"] . " - " . $ligne["email_contact"] . " - " . $ligne["telephone_contact"] . "</li>";
                }
                echo('</ul>');
            }
        } 
        else
        {
            echo "Erreur: " . $sql1 . "<br>" . $conn->error;
        }
        $conn->close();
    }
    endif;   
?>