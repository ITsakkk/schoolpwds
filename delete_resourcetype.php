<?php
    include_once 'connection.php';
if(isset($_GET['ResourceTypeID']))
{    
     $ResourceTypeID = $_GET['ResourceTypeID'];
     $sql = "Delete from tblresourcetype Where ResourceTypeID=$ResourceTypeID";
     $conn->query($sql);
}

Header("Location: display_resourcetype.php");
?>