<?php
    include_once 'connection.php';
if(isset($_GET['subjectid']))
{    
     $subjectid = $_GET['subjectid'];
     $sql = "Delete from tblsubject Where subjectid=$subjectid";
     $conn->query($sql);
}

Header("Location: display_subject.php");
?>