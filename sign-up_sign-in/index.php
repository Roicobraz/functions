<?php require('header.php');?>
    <body>
        <h1>Formulaire de Contact</h1>
        <p>
            <h3>Ajout de Contact</h3>
            <form action="traitement.php" method='post'>
                <p>
                    <label>Nom : </label>
                    <input type="text" name='nom' required>
                </p>

                <p>
                    <label>Prénom : </label>
                    <input type="text" name='prenom' required>
                </p>

                <p>
                    <label>e-mail : </label>
                    <input type="email" name='email' required>
                </p>

                <p>
                    <label>Numéro de téléphone : </label>
                    <input type="tel" name='tel' maxlength="14" required>
                </p>
                <input type='submit' value='Envoyer'>
                <input type='reset'>
            </form>
        </p>
        
        <p>
            <h3>Consultation de Contact</h3>
            <form action='get.php' method="get">
                <label>Voir l'utilisateur : </label>
                <select name='id_contact'>
                <option value="" disabled selected>Selectionnez votre utilisateur</option>
                <?php
                    
                    $conn = serv_init();
                    $sql1 = "SELECT prenom_contact, nom_contact, id_contact FROM contact;";

                    if ( $resultat = $conn->query($sql1) )
                    {
                        if($resultat->num_rows > 0) {
                            echo('<ul>');
                            while ($ligne = $resultat->fetch_assoc()) {
                                echo '<option value="'.$ligne["id_contact"].'">'.$ligne["nom_contact"].' '.$ligne["prenom_contact"] .'</option>';
                            }
                            echo('</ul>');
                        }
                    } 
                    else { echo "Erreur: " . $sql1 . "<br>" . $conn->error; }
                    $conn->close();
                    ?>
                </select>
                <input type='submit' value="Afficher l'utilisateur">   
            </form>   
        </p>

        <p>
            <h3>Suppression de Contact</h3>
            <form action='suppr.php' method="get">
                <label>Voir l'utilisateur : </label>
                <select name='id_contact'>
                <option value="" disabled selected>Selectionnez votre utilisateur</option>
                <?php
                    $conn = serv_init();
                    $sql1 = "SELECT prenom_contact, nom_contact, id_contact FROM contact;";

                    if ( $resultat = $conn->query($sql1) )
                    {
                        if($resultat->num_rows > 0) {
                            echo('<ul>');
                            while ($ligne = $resultat->fetch_assoc()) {
                                echo '<option value="'.$ligne["id_contact"].'">'.$ligne["nom_contact"].' '.$ligne["prenom_contact"] .'</option>';
                            }
                            echo('</ul>');
                        }
                    } 
                    else { echo "Erreur: " . $sql1 . "<br>" . $conn->error; }
                    $conn->close();
                    ?>
                </select>
                <input type='submit' value="Supprimer l'utilisateur">   
            </form>   
        </p>

       <!-- <p>
            <h3>Connexion</h3>à faire
            <form action='log-in.php' method="get">
                <label>Voir l'utilisateur : </label>
                <select name='id_contact'>
                <option value="" disabled selected>Selectionnez votre utilisateur</option>
                <?php
                    $conn = serv_init();
                    $sql1 = "SELECT prenom_contact, nom_contact, id_contact FROM contact;";

                    if ( $resultat = $conn->query($sql1) )
                    {
                        if($resultat->num_rows > 0) {
                            echo('<ul>');
                            while ($ligne = $resultat->fetch_assoc()) {
                                echo '<option value="'.$ligne["id_contact"].'">'.$ligne["nom_contact"].' '.$ligne["prenom_contact"] .'</option>';
                            }
                            echo('</ul>');
                        }
                    } 
                    else { echo "Erreur: " . $sql1 . "<br>" . $conn->error; }
                    $conn->close();
                    ?>
                </select>
                <input type='submit' value="Supprimer l'utilisateur">   
            </form>   
        </p>-->

        <p>
            <?php 
            $nom = 'test';
            $prenom = 'test';
            $email = 'test';
            $tel = 'test';

            $args = [
                'table' => 'contact', 'values' => $nom.','.$prenom.','.$email.','.$tel,
                'data' => 'nom_contact,prenom_contact,email_contact,telephone_contact',
                
            ];
           // echo(cstm_insert($args)); ?>
        </p>
    </body>
    <?php cstm_footer();?>
</html>

