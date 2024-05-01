<?php
// Include the connection file
include("connection.php");

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentID = $_POST['studentid'];
    $programID = $_POST['programid'];
    $assigned = $_POST['assigned'];
    $note = $_POST['note'];
    $assignDate = $_POST['assigndate'];

    // Prepare SQL statement to insert data into tblstudentstatus
    $sql = "INSERT INTO tblstudentstatus (studentid, programid, assigned, note, assigndate) 
            VALUES ('$studentID', '$programID', '$assigned', '$note', '$assignDate')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        header("Location: tap.php?studentid=$studentID");
        exit();
    } else {
        // If an error occurs during insertion, display an error message
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} 
?>