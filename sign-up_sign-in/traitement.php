<?php require('header.php');


    $conn = serv_init();

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];

    $query = "SELECT * FROM contact WHERE email_contact = '$email'";

    $result = $conn->query($query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo ('L\'adresse e-mail est déjà attribué');
        } else {
            // $args = [
            //     'table' => 'contact', 
            //     'values' => $nom.','.$prenom.','.$email.','.$tel,
            //     'data' => 'nom_contact,prenom_contact,email_contact,telephone_contact'];
            // $add = cstm_insert($args);
            // echo($add);
            $add = "INSERT INTO contact (nom_contact,prenom_contact,email_contact,telephone_contact) VALUES ('".$nom."','".$prenom."','".$email."','".$tel."')";

            if ($conn->query($add)) :
            {
                echo "Nouveau contact ajout&eacute;";
            } else:
            {
                echo "Erreur: " . $add . "<br>" . $conn->error;
            }
            endif;
        }
    } else {
        echo 'Error: ' . mysqli_error();
    }

   

    $conn->close();
?><?php cstm_footer();?>