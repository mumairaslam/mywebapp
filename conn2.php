<?php

//variables

$hostname = "myserversql.mysql.database.azure.com";
$username = "umair";
$password = "Um@ir2464";  
$dbname = "videos1";
//connection

$conn = mysqli_connect($hostname, $username,$password, $dbname )
       or die("Not connected");

//query

$sql = "delete from users where username = 'sharjeel'";
 if (!mysqli_query($conn,$sql )) 
 {
    die("Error in delete query" .mysqli_error());
 } 
 echo  "Data has been deleted";     
 mysqli_close($conn)                    




?>