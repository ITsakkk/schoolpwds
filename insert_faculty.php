<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $facultykh = $_POST['facultykh'];
        $facultyen = $_POST['facultyen'];


        $sql = "INSERT INTO tblfaculty (facultykh, facultyen) VALUES ('$facultykh','$facultyen')";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_faculty.php");
?>