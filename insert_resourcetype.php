<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $ResourceTypeName = $_POST['ResourceTypeName'];


        $sql = "INSERT INTO tblresourcetype (ResourceTypeName) VALUES ('$ResourceTypeName')";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_resourcetype.php");
?>