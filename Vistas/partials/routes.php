
<?php require('../../../vendor/autoload.php'); ?>
<?php
$dotenv = Dotenv\Dotenv::create("../../../");
$dotenv->load();

$baseURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
//https://localhost/optica-ocular-center/
$adminlteURL = $baseURL."/vendor/almasaeed2010/adminlte";
//https://localhost/optica-ocular-center/vendor/almasaeed2010/adminlte
?>
