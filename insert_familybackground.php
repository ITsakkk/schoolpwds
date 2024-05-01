<?php
include("connection.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fathername = $_POST['fathername'];
    $fatherage = $_POST['fatherage'];
    $fathernationalityid = $_POST['fathernationalityid'];
    $fathercountryid = $_POST['fathercountryid'];
    $fatheroccupationid = $_POST['fatheroccupationid'];
    $mothername = $_POST['mothername'];
    $motherage = $_POST['motherage'];
    $mothernationalityid = $_POST['mothernationalityid'];
    $mothercountryid = $_POST['mothercountryid'];
    $motheroccupationid = $_POST['motheroccupationid'];
    $familycurrentaddress = $_POST['familycurrentaddress'];
    $spousename = $_POST['spousename'];
    $spouseage = $_POST['spouseage'];
    $guardianphonenumber = $_POST['guardianphonenumber'];
    $studentid = $_POST['studentid']; // Corrected variable name

    $sql = "INSERT INTO tblfamilybackground (fathername, fatherage, fathernationalityid, fathercountryid, fatheroccupationid, mothername, motherage, mothernationalityid, mothercountryid, motheroccupationid, familycurrentaddress, spousename, spouseage, guardianphonenumber, studentid) 
            VALUES ('$fathername', '$fatherage', '$fathernationalityid', '$fathercountryid', '$fatheroccupationid', '$mothername', '$motherage', '$mothernationalityid', '$mothercountryid', '$motheroccupationid', '$familycurrentaddress', '$spousename', '$spouseage', '$guardianphonenumber', '$studentid')";

    // Execute SQL statement
    if (mysqli_query($conn, $sql)) {
        header("Location: form_edubackground.php?studentid=$studentid"); 
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>