<?php require('header.php');
    $conn = serv_init();

    if(!empty($_GET['id_contact'])):
    {
        $sql1 = "SELECT prenom_contact, nom_contact, email_contact, telephone_contact FROM contact WHERE id_contact = ".$_GET['id_contact'];

        if ($resultat = $conn->query($sql1) ) 
        {
            if($resultat->num_rows > 0) {
                while ($ligne = $resultat->fetch_assoc()) {
                    $prenom = $ligne["prenom_contact"];
                    $nom = $ligne["nom_contact"];
                    $mail = $ligne["email_contact"];
                    $tel = $ligne["telephone_contact"];

                    $code_html = '
                        <h1>'.$nom.$prenom.'</h1>
                        <ul>
                            <li>'.$mail.'</li>
                            <li>'.$tel.'</li>
                        </ul>
                        <div>
                            <!--<button onclick="click()">Modifier</button>-->
                            <h3>Modifier l\'utilisateur</h3>
                        </div>
                        <form id="modified" action="modified.php?id_contact='.$_GET["id_contact"].'" method="post">
                        <p>
                            <label>Nom : </label>
                            <input type="text" name="nom" placeholder="'.$nom.'" >
                        </p>
        
                        <p>
                            <label>Prénom : </label>
                            <input type="text" name="prenom" placeholder="'.$prenom.'" >
                        </p>
        
                        <p>
                            <label>e-mail : </label>
                            <input type="email" name="email" placeholder="'.$mail.'" >
                        </p>
        
                        <p>
                            <label>Numéro de téléphone : </label>
                            <input type="tel" name="tel" maxlength="14" placeholder="'.$tel.'" >
                        </p>
                        <input type="submit" value="Envoyer">
                        <input type="reset">
                    </form>';
                    echo $code_html;
                }
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

<?php cstm_footer();?>