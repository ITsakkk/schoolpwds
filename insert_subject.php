<?php
    
    include("connection.php");
    
    $ErrorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $subjectkh = $_POST['subjectkh'];
        $sbujecten = $_POST['subjecten'];
        $creditnumber = $_POST['creditnumber'];
        $hours = $_POST['hours'];
        $faculty = $_POST['faculty'];
        $major = $_POST['major'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];


        $sql = "INSERT INTO tblsubject (subjectkh, subjecten, creditnumber, hours, facultyid, majorid, yearid, 	semesterid)
         VALUES ('$subjectkh','$sbujecten', $creditnumber, $hours, $faculty, $major, $year, $semester)";
        $result = $conn->query($sql);
        if(!$result){
            $ErrorMessage = "Invalid Query: ". $conn->error;
        }
    }
    

    header("Location: display_subject.php");
?>