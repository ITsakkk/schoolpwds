<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "db_project_01";

    $conn=mysqli_connect($servername,$username,$password,"$dbname");

    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }

?>