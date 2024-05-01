<?php
    include_once 'connection.php';
if(isset($_GET['majorid']))
{    
     $majorid = $_GET['majorid'];
     $sql = "Delete from tblmajor Where majorid=$majorid";
     $conn->query($sql);
}

Header("Location: display_major.php");
?>