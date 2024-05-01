<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include("script.php");
        include("connection.php");
        $ResourceTypeID = $_GET['ResourceTypeID'];
        
        $query = "SELECT 
        tblresourcetype.ResourceTypeID,
        tblresourcetype.ResourceTypeName
    FROM 
        tblresourcetype";

// Query to retrieve subject details based on the subject ID
$query .= " WHERE tblresourcetype.ResourceTypeID = $ResourceTypeID";
$result = mysqli_query($conn, $query);

// Check if the query returned any results
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch subject details
    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect or display an error message
    echo "Major not found.";
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
                View Resource Type
            </div>
        </div>
        <div class="row row py-4 bg-light">
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Year ID</label>
            </div>
            <div class="col-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceTypeID'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Year EN</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['ResourceTypeName'];
                ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 p-0 py-2">
                <a class="btn bg-primary text-white m-0" href="display_resourcetype.php">
                    Cancel</a>
                <a class="btn bg-primary text-white m-0"
                    href="edit_resourcetype.php?ResourceTypeID=<?php echo $row['ResourceTypeID'] ?>">
                    Edit</a>
            </div>
        </div>


    </div>
    <!-- end of content -->

</body>

</html>