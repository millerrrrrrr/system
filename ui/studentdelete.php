<?php

include_once 'connectdb.php';



$id = $_POST['id'];
$sql = "delete from tbl_student where id =$id";

$delete = $pdo->prepare($sql);

if ($delete->execute()) {
} else {


    echo "Error on removing student";
}
