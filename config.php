<?php  

$host = "localhost";
$user = "root";
$password = "";
$db= "drag-drop";

$conn = new mysqli($host, $user, $password, $db);

if($conn){
}else{
    echo "Failed";
}


?>