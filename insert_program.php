<?php
// Include the database connection script
include("connection.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $yearid = $_POST['yearid'];
    $semesterid = $_POST['semesterid'];
    $shiftid = $_POST['shiftid'];
    $degreeid = $_POST['degreeid'];
    $academicyearid = $_POST['academicyearid'];
    $majorid = $_POST['majorid'];
    $batchid = $_POST['batchid'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $dateissue = $_POST['dateissue'];

    // Prepare the SQL insert statement
    $query = "INSERT INTO tblprogram (yearid, semesterid, shiftid, degreeid, academicyearid, majorid, batchid, startdate, enddate, dateissue)
              VALUES ('$yearid', '$semesterid', '$shiftid', '$degreeid', '$academicyearid', '$majorid', '$batchid', '$startdate', '$enddate', '$dateissue')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        header("Location: display_program.php");
        exit();
    } else {
        // If an error occurs, display an error message
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>