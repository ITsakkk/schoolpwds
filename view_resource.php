<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include("script.php");
        include("connection.php");
        $subject_id = $_GET['ResourceID'];
        
        $query = "SELECT 
        tblresource.ResourceID,
        tblresource.ResourceName,
        tblresource.ResourceURL,
        tblresourcetype.ResourceTypeName,
        tblsubject.subjecten
    FROM 
        tblresource
    INNER JOIN 
        tblsubject ON tblresource.subjectid = tblsubject.subjectid
    INNER JOIN 
        tblresourcetype ON tblresource.resourcetypeid = tblresourcetype.resourcetypeid";

// Query to retrieve subject details based on the subject ID
$query .= " WHERE tblresource.ResourceID = $subject_id";
$result = mysqli_query($conn, $query);

// Check if the query returned any results
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch subject details
    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect or display an error message
    echo "Resource not found.";
    exit;
}
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4 pb-2">
        <div class="row">
            <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                View Resource
            </div>
        </div>
        <div class="row row py-4 bg-light">
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Resource ID</label>
            </div>
            <div class="col-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceID'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Resource Name</label>
            </div>
            <div class="col-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceName'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Resource Type</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceTypeName'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Resource URL</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceURL'];
                ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Subject</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['subjecten'];
                ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 p-0 py-2">
                <a class="btn bg-primary text-white m-0" href="display_resource.php">
                    Cancel</a>
                <a class="btn bg-primary text-white m-0"
                    href="edit_resource.php?ResourceID=<?php echo $row['ResourceID'] ?>">
                    Edit</a>
            </div>
        </div>


    </div>
    <!-- end of content -->

</body>

</html>