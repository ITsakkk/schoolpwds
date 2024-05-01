<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resource</title>
    <!-- Include necessary scripts and stylesheets -->
    <?php
    include("script.php");
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission for updating resource
        $resourceId = $_GET['ResourceID'] ?? '';
        $resourcename = $_POST['resourcename'] ?? '';
        $resourcetype = $_POST['resourcetype'] ?? '';
        $subjectid = $_POST['subjectid'] ?? '';

        // Check if subjectid is selected, if not, select the first one
        if (empty($subjectid)) {
            $query_subject = "SELECT subjectid FROM tblsubject LIMIT 1";
            $result_subject = mysqli_query($conn, $query_subject);
            $row_subject = mysqli_fetch_assoc($result_subject);
            $subjectid = $row_subject['subjectid'];
        }

        // File upload handling
        if (!empty($_FILES["resourcefile"]["name"])) {
            $fileName = basename($_FILES["resourcefile"]["name"]);
            $targetFilePath = "img/" . $fileName;

            // Move uploaded file to img folder
            if (move_uploaded_file($_FILES["resourcefile"]["tmp_name"], $targetFilePath)) {
                $resourceURL = $fileName; // Use new file name if uploaded
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            // If no new file is selected, retain the old file data
            $query_old_url = "SELECT ResourceURL FROM tblresource WHERE ResourceID = $resourceId";
            $result_old_url = mysqli_query($conn, $query_old_url);
            $row_old_url = mysqli_fetch_assoc($result_old_url);
            $resourceURL = $row_old_url['ResourceURL'];
        }

        // Update resource data in the database
        $query = "UPDATE tblresource SET ResourceName=?, ResourceTypeID=?, SubjectID=?, ResourceURL=? WHERE ResourceID=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssisi", $resourcename, $resourcetype, $subjectid, $resourceURL, $resourceId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Resource updated successfully.";
            header("location: display_resource.php");
            exit(); // Ensure script stops executing after redirection
        } else {
            echo "Error updating resource.";
        }
    } else {
        // If the form is not submitted, display the form for editing resource
        $resourceId = $_GET['ResourceID'] ?? '';
        if (!empty($resourceId)) {
            $query = "SELECT * FROM tblresource WHERE ResourceID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $resourceId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $existingResource = mysqli_fetch_assoc($result);
            if (!$existingResource) {
                echo "Resource not found.";
                exit(); // Ensure script stops executing after error message
            }
        } else {
            echo "Resource ID not provided.";
            exit(); // Ensure script stops executing after error message
        }
    }
    ?>
</head>

<body>
    <!-- Include admin sidebar if needed -->
    <!-- Assuming admin_sidebar.php contains the sidebar code -->
    <?php
    include("admin_sidebar.php");
    ?>
    <!-- End of sidebar -->

    <div class="content px-4 pb-2">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Resource
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource Name</label>
                    <input type="text" name="resourcename" class="form-control"
                        value="<?php echo $existingResource['ResourceName'] ?? ''; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource Type</label>
                    <select name="resourcetype" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
                        $query = "SELECT * FROM tblresourcetype"; // Assuming tblresourcetype contains resource types
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['ResourceTypeID'] == $existingResource['ResourceTypeID']) ? 'selected' : '';
                            echo "<option value='{$row['ResourceTypeID']}' $selected>{$row['ResourceTypeName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource URL</label>
                    <input type="file" name="resourcefile" class="form-control">
                    <input type="hidden" name="oldresourceurl"
                        value="<?php echo $existingResource['ResourceURL'] ?? ''; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject Name</label>
                    <select name="subjectid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
                        $query = "SELECT * FROM tblsubject"; // Assuming tblsubject contains subjects
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['subjectid'] == $existingResource['subjectid']) ? 'selected' : '';
                            echo "<option value='{$row['subjectid']}' $selected>{$row['subjecten']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_resource.php">Cancel</a>
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>