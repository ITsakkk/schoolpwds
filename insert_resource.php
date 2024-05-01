<?php
// Include the database connection script
include("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $resourcename = $_POST['resourcename'];
    $resourcetype = $_POST['resourcetype'];
    $subjectid = $_POST['subjectid'];

    // File upload handling
    $targetDir = "img/"; // Directory where files will be uploaded
    $fileName = basename($_FILES["resourcefile"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Upload file to server
    if(move_uploaded_file($_FILES["resourcefile"]["tmp_name"], $targetFilePath)){
        // Insert data into database
        $query = "INSERT INTO tblresource (ResourceName, ResourceTypeID, SubjectID, ResourceURL) VALUES ('$resourcename', '$resourcetype', '$subjectid', '$fileName')";
        if(mysqli_query($conn, $query)){
            header("location: display_resource.php");
        }else{
            echo "Error adding resource to the database.";
        }
    }else{
        echo "Error uploading file.";
    }
}else{
    echo "Form submission method not allowed.";
}
?>