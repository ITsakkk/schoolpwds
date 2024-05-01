<?php
// Include the database connection file
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameinkhmer = $_POST['nameinkhmer'];
    $nameinlatin = $_POST['nameinlatin'];
    $familyname = $_POST['familyname'];
    $givenname = $_POST['givenname'];
    $sexid = $_POST['sexid'];
    $statusid = $_POST['statusid'];
    $idpassportno = $_POST['idpassportno'];
    $nationalityid = $_POST['nationalityid'];
    $countryid = $_POST['countryid'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $currentaddress = $_POST['currentaddress'];
    $currentaddresspp = $_POST['currentaddresspp'];
    $registerdate = $_POST['registerdate'];

    // File upload handling
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_name = $_FILES['photo']['name'];
    $photo_type = $_FILES['photo']['type'];
    $photo_size = $_FILES['photo']['size'];
    $photo_error = $_FILES['photo']['error'];

    $targetDir = "img/"; // Directory where files will be uploaded
    $photo = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . $photo;

    // Upload file to server
    if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
            // Insert data into tblstudentinfo
            $query = "INSERT INTO tblstudentinfo (nameinkhmer, nameinlatin, familyname, givenname, sexid, idpassportno, nationalityid, countryid, dob, pob, phonenumber, email, currentaddress, currentaddresspp, photo, registerdate, statusid) 
                      VALUES ('$nameinkhmer', '$nameinlatin', '$familyname', '$givenname', '$sexid', '$idpassportno', '$nationalityid', '$countryid', '$dob', '$pob', '$phonenumber', '$email', '$currentaddress', '$currentaddresspp', '$photo', '$registerdate', '$statusid')";
            
            if (mysqli_query($conn, $query)) {
                // Get the ID of the inserted student
                $studentid = mysqli_insert_id($conn);
                header("Location: form_familybackground.php?studentid=$studentid");
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