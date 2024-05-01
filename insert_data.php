<?php
include("connection.php"); // Include your database connection file

// Insert data into tblstudentinfo
$query_studentinfo = "INSERT INTO tblstudentinfo (nameinkhmer, nameinlatin, familyname, givenname, sexid, idpassportno, nationalityid, countryid, dob, pob, phonenumber, email, currentaddress, currentaddresspp, photo, registerdate) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_studentinfo = mysqli_prepare($conn, $query_studentinfo);
mysqli_stmt_bind_param($stmt_studentinfo, "ssssssssssssssss", $nameinkhmer, $nameinlatin, $familyname, $givenname, $sexid, $idpassportno, $nationalityid, $countryid, $dob, $pob, $phonenumber, $email, $currentaddress, $currentaddresspp, $photo, $registerdate);

$nameinkhmer = "Your Khmer Name";
$nameinlatin = "Your Latin Name";
$familyname = "Your Family Name";
$givenname = "Your Given Name";
$sexid = 1; // Assuming 1 represents Male and 2 represents Female
$idpassportno = "Your Passport Number";
$nationalityid = 1; // Assuming 1 represents your nationality
$countryid = 1; // Assuming 1 represents your country
$dob = "1990-01-01"; // Your date of birth
$pob = "Your Place of Birth";
$phonenumber = "Your Phone Number";
$email = "Your Email";
$currentaddress = "Your Current Address";
$currentaddresspp = "Your Current Address PP";
$photo = "your_photo.jpg"; // Assuming you have uploaded the photo and stored the filename
$registerdate = date("Y-m-d"); // Current date

mysqli_stmt_execute($stmt_studentinfo);

if (mysqli_stmt_affected_rows($stmt_studentinfo) > 0) {
    echo "Data inserted successfully into tblstudentinfo.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt_studentinfo);


// Insert data into tblfamilybackground
$query_familybackground = "INSERT INTO tblfamilybackground (studentid, fathername, fatheroccupation, mothername, motheroccupation, numberofsiblings) 
                           VALUES (?, ?, ?, ?, ?, ?)";
$stmt_familybackground = mysqli_prepare($conn, $query_familybackground);
mysqli_stmt_bind_param($stmt_familybackground, "issssi", $studentid, $fathername, $fatheroccupation, $mothername, $motheroccupation, $numberofsiblings);

$studentid = 1; // Assuming 1 represents the student ID
$fathername = "Father's Name";
$fatheroccupation = "Father's Occupation";
$mothername = "Mother's Name";
$motheroccupation = "Mother's Occupation";
$numberofsiblings = 2; // Number of siblings

mysqli_stmt_execute($stmt_familybackground);

if (mysqli_stmt_affected_rows($stmt_familybackground) > 0) {
    echo "Data inserted successfully into tblfamilybackground.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt_familybackground);


// Insert data into tbleducationalbackground
$query_educationalbackground = "INSERT INTO tbleducationalbackground (studentid, schoolname, schooladdress, program, level, yeargraduated) 
                                VALUES (?, ?, ?, ?, ?, ?)";
$stmt_educationalbackground = mysqli_prepare($conn, $query_educationalbackground);
mysqli_stmt_bind_param($stmt_educationalbackground, "isssis", $studentid, $schoolname, $schooladdress, $program, $level, $yeargraduated);

$studentid = 1; // Assuming 1 represents the student ID
$schoolname = "School Name";
$schooladdress = "School Address";
$program = "Program Name";
$level = "Education Level";
$yeargraduated = "Year Graduated";

mysqli_stmt_execute($stmt_educationalbackground);

if (mysqli_stmt_affected_rows($stmt_educationalbackground) > 0) {
    echo "Data inserted successfully into tbleducationalbackground.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt_educationalbackground);

mysqli_close($conn); // Close the database connection
?>