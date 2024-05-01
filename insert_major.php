<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $facultyid = $_POST['facultyid'];
        $majorkh = $_POST['majorkh'];
        $majoren = $_POST['majoren'];


        $sql = "INSERT INTO tblmajor (majorkh, majoren, facultyid) VALUES ('$majorkh','$majoren', $facultyid)";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_major.php");
?>