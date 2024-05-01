<?php

    include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["faculty"])) {
    $facultyId = $_POST["faculty"];

    // Fetch districts for the selected faculty
    $query = "SELECT * FROM tblmajor WHERE facultyid = '$facultyId'";
    $result = mysqli_query($conn, $query);

    // Generate options for the select dropdown
    $options = "<option value=''>Select Major</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['majorid']}'>{$row['majoren']}</option>";
    }

    // Send the options back as JSON response
    echo json_encode(["success" => true, "options" => $options]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

// Close the database connection
mysqli_close($conn);
?>