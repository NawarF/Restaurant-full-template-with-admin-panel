<?php

$servername ='localhost';
$username='root';
$password='';
$dbname='shoppingcart';

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn){
    die('error');
}

?>