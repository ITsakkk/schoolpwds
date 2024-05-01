<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectid = $_POST['subjectid'];
    $lecturerid = $_POST['lecturerid'];
    $programid = $_POST['programid'];
    $dayweekid = $_POST['dayweekid'];
    $timeid = $_POST['timeid'];
    $roomid = $_POST['roomid'];
    $datestart = $_POST['datestart'];
    $dateend = $_POST['dateend'];
    $scheduledate = $_POST['scheduledate'];
    $statusid = $_POST['statusid'];

    // Perform insert query
    $query = "INSERT INTO tblschedule (lecturerid, subjectid, programid, dayweekid, timeid, roomid, datestart, dateend, scheduledate,statusid) 
              VALUES ('$lecturerid', '$subjectid', '$programid', '$dayweekid', '$timeid', '$roomid', '$datestart', '$dateend', '$scheduledate', '$statusid')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: tap_lecturer.php?lecturerid=$lecturerid");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Invalid request method!";
}
?>