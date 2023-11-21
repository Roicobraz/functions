<?php
   $GLOBALS['settings'] = [ 'database' => [
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'dbname' => 'ex1'
        ],
        'site' => [
            'url' => 'http://localhost/justin.vavassori/ex1/',
        ]];

    function serv_init(){
        $servername = $GLOBALS['settings']['database']['host'];
        $username   = $GLOBALS['settings']['database']['user'];
        $password   = $GLOBALS['settings']['database']['password'];
        $dbname     = $GLOBALS['settings']['database']['dbname'];
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) :
        {
            die("&Eacute;chec de connection : " . $conn->connect_error);
        }
        endif;

        return ($conn);
    }

    function cstm_footer() {
        echo("<footer></footer>");
    }

    function cstm_insert($args) {
        if(!empty($args['table'])): { $table = $args['table']; } else: {echo"Erreur, entrez une table.";die;}endif;
        if(!empty($args['data'])): { $data = $args['data']; } else: {$data = '*';}endif;
        if(!empty($args['values'])): { $values = $args['values']; } else: {echo"Erreur, entrez une valeur.";die;}endif;

        $query = "INSERT INTO ".$table." (".$data.") VALUES ('".$values."')";
        return($query);
    }
?>