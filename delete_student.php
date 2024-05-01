<?php
include_once 'connection.php';

if(isset($_GET['studentid'])) {    
    $studentid = $_GET['studentid'];
    
    // Update the status to '2' instead of deleting
    $sql = "UPDATE tblstudentinfo SET statusid = 2 WHERE studentid = $studentid";
    $conn->query($sql);
}

header("Location: display_student.php");
exit;
?>