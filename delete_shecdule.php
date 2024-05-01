<?php
include_once 'connection.php';

if(isset($_GET['scheduleid'])) {    
    $scheduleid = $_GET['scheduleid'];
    
    // Update the status to '2' instead of deleting
    $sql = "UPDATE tblschedule SET statusid = 2 WHERE scheduleid = $scheduleid";
    $conn->query($sql);
}

header("Location: display_shecdule.php");
exit;
?>