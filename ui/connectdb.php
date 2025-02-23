<?php

try{

    $pdo = new PDO('mysql:host=localhost;dbname=miller_db','root','');


}catch(PDOException $e ){

   echo $e->getMessage();

}

// echo 'connected';


?>