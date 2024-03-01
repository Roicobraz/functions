<?php 
    define('__ROOT__', dirname(dirname(__FILE__)));

    $GLOBALS['settings'] = [ 'database' => [
            'host' => 'localhost',
            'user' => 'justin',
            'password' => 'hL3*c[4BxGzY1!I9EQ6L',
            'dbname' => 'pdm_signature'
        ],
        'site' => [
            'url' => 'https://synology.pagedemarque.com/justinsandbox/signature/',
        ]];

    function surl($withTild){
        require_once __DIR__.'/function.php';
        $baseUrl = $GLOBALS['settings']['site']['url'];
        $wip = str_replace("~/", $baseUrl, $withTild);

        return $wip;
    }

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