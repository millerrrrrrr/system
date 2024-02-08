<?php

try{

    $pdo = new PDO('mysql:host=localhost;dbname=pos_mil_db','root','');


}catch(PDOException $e ){

   echo $e->getMessage();

}

// echo 'connected';


?>