<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "expense_tracker";

$link = new mysqli($server,$username,$password,$db);
if($link->connect_error){
    die("Error".$link->connect_error);
}
// }else{
//     echo "connection success full";
// }
    







































?>