<?php
        include("script.php");
        include("connection.php");

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Initialize variables with form data
            $nameschool = $_POST['nameschool'];
            $schooltypeid = $_POST['schooltypeid'];
            $academicyear = $_POST['academicyear'];
            $province = $_POST['province'];
            $studentid = $_POST['studentid'];

            // Prepare the SQL statement
            $query = "INSERT INTO tbleducationalbackground (nameschool, schooltypeid, academicyear, province, studentid) 
                      VALUES ('$nameschool', '$schooltypeid', '$academicyear', '$province', '$studentid')";

            // Execute the SQL statement
            if (mysqli_query($conn, $query)) {
                header("Location: form_studentstatus.php?studentid=$studentid"); 
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    ?>