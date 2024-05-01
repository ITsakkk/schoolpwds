<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameinkh = $_POST['nameinkh'];
    $nameinlatin = $_POST['nameinlatin'];
    $familyname = $_POST['familyname'];
    $givenname = $_POST['givenname'];
    $sexid = $_POST['sexid'];
    $passportid = $_POST['passportid'];
    $nationalityid = $_POST['nationalityid'];
    $countryid = $_POST['countryid'];
    $professionalexperience = $_POST['professionalexperience'];
    $degreeid = $_POST['degreeid'];
    $departmentid = $_POST['departmentid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $publications = $_POST['publications'];
    $pob = $_POST['pob'];
    $address = $_POST['address'];
    $statusid = $_POST['statusid'];

    $targetDir = "img/"; // Directory where files will be uploaded
    $photo = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . $photo;

    // Upload file to server
    if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
            // Insert data into tblstudentinfo
            $query = "INSERT INTO tbllecturer (nameinkh, nameinlatin, familyname, givenname, sexid, passportid, nationalityid, countryid, professionalexperience, degreeid, departmentid, email, phone, dob, publications, pob, address, photo, statusid) 
                      VALUES ('$nameinkh', '$nameinlatin', '$familyname', '$givenname', '$sexid', '$passportid', '$nationalityid', '$countryid', '$professionalexperience', '$degreeid', '$departmentid', '$email', '$phone', '$dob', '$publications', '$pob', '$address', '$photo', '$statusid')";
            
            if (mysqli_query($conn, $query)) {
                // Get the ID of the inserted student
                $lecturerid = mysqli_insert_id($conn);
                header("Location: tap_lecturer.php?lecturerid=$lecturerid");
                exit(); 
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error uploading file.";
        }

    // Close database connection
    mysqli_close($conn);
}
?>