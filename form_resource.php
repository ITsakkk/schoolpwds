<?php
// Include necessary scripts and connection
include("script.php");
include("connection.php");

// Retrieve subject ID from URL parameter
$selectedSubjectId = isset($_GET['subjectid']) ? $_GET['subjectid'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Selection</title>
    <!-- Include necessary scripts and stylesheets -->
    <?php
        include("script.php"); // Include any necessary scripts
        include("connection.php"); // Include database connection script
    ?>
</head>

<body>

    <?php
    include("admin_sidebar.php");
    ?>
    <!-- End of sidebar -->

    <div class="content px-4 pb-2">
        <form method="POST" enctype="multipart/form-data" action="insert_resource.php">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Resource
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource Name</label>
                    <input type="text" name="resourcename" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource Type</label>
                    <select name="resourcetype" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
                        $query = "SELECT * FROM tblresourcetype"; // Assuming tblresourcetype contains resource types
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['ResourceTypeID']}'>{$row['ResourceTypeName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource URL</label>
                    <input type="file" name="resourcefile" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject Name</label>
                    <select name="subjectid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
                        $query = "SELECT * FROM tblsubject"; // Assuming tblsubject contains subjects
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['subjectid'] == $selectedSubjectId) ? 'selected' : '';
                            echo "<option value='{$row['subjectid']}' $selected>{$row['subjecten']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_resource.php">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    // You can include any additional JavaScript code here
    </script>
</body>

</html>