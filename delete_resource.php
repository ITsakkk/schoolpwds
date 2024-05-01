<?php
    include_once 'connection.php';
if(isset($_GET['ResourceID']))
{    
     $ResourceID = $_GET['ResourceID'];
     $sql = "Delete from tblresource Where ResourceID=$ResourceID";
     $conn->query($sql);
}

Header("Location: display_resource.php");
?>