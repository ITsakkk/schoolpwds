<?php
include_once 'connection.php';

if(isset($_GET['lecturerid'])) {    
    $lecturerid = $_GET['lecturerid'];
    
    // Update the status to '2' instead of deleting
    $sql = "UPDATE tbllecturer SET statusid = 2 WHERE lecturerid = $lecturerid";
    $conn->query($sql);
}

header("Location: display_lecturer.php");
exit;
?>