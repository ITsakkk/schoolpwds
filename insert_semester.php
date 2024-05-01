<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $semesterkh = $_POST['semesterkh'];
        $semesteren = $_POST['semesteren'];


        $sql = "INSERT INTO tblsemester (semesterkh, semesteren) VALUES ('$semesterkh','$semesteren')";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_semester.php");
?>