<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $yearkh = $_POST['yearkh'];
        $yearen = $_POST['yearen'];


        $sql = "INSERT INTO tblyear (yearkh, yearen) VALUES ('$yearkh','$yearen')";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_year.php");
?>