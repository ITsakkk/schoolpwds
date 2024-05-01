<?php
    include_once 'connection.php';
if(isset($_GET['facultyid']))
{    
     $facultyid = $_GET['facultyid'];
     $sql = "Delete from tblfaculty Where facultyid=$facultyid";
     $conn->query($sql);
}

Header("Location: display_faculty.php");
?>