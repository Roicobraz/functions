<?php
   $GLOBALS['settings'] = [
        'database' => [
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'dbname' => 'ex1'
        ]
    ];

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
?>