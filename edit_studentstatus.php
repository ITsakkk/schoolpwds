<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['studentstatusid'])) {
    $studentstatusid = $_GET['studentstatusid'];

    // Retrieve student information from the database
    $query = "SELECT * FROM tblstudentstatus WHERE studentstatusid = $studentstatusid";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $programID = $row['programid'];
        $studentid = $row['studentid'];
        $studentstatusid = $row['studentstatusid'];
        $assigned = $row['assigned'];
        $note = $row['note'];
        $assignDate = $row['assigndate'];
    } else {
        echo "Student not found.";
        exit;
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $studentstatusid = $_POST['studentstatusid'];
    $studentid = $_POST['studentid'];
    $programID = $_POST['programid'];
    $assigned = $_POST['assigned'];
    $note = $_POST['note'];
    $assignDate = $_POST['assigndate'];

    // Update student information in the database
    $query_update = "UPDATE tblstudentstatus SET  programid = '$programID', assigned = '$assigned', note = '$note', assigndate = '$assignDate' WHERE studentstatusid = $studentstatusid";
    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
        header("Location: tap.php?studentid=$studentid");
    } else {
        echo "Error updating student status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Status</title>
    <?php include("script.php"); ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- End of Sidebar -->
    <div class="content px-4 pb-2">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Student Status
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student ID</label>
                    <input type="text" value="<?php echo $studentid ?>" name="studentid" id="studentid"
                        class="form-control" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="studentstatusid" class="form-label">Student Status ID</label>
                    <input type="text" value="<?php echo $studentstatusid ?>" name="studentstatusid"
                        id="studentstatusid" class="form-control" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="programid" class="form-label">Program ID</label>
                    <select name="programid" id="programid" class="form-control">
                        <?php
                        // Fetch programs from the database
                        $query_programs = "SELECT * FROM tblprogram";
                        $result_programs = mysqli_query($conn, $query_programs);
                        while ($row_program = mysqli_fetch_assoc($result_programs)) {
                            // Check if the current program ID matches the fetched program ID
                            $selected = ($programID == $row_program['programid']) ? 'selected' : '';
                            echo "<option value='{$row_program['programid']}' $selected>{$row_program['programid']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="assigned" class="form-label">Assigned</label>
                    <input type="text" value="<?php echo $assigned ?>" name="assigned" id="assigned"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" id="note" class="form-control"><?php echo $note ?></textarea>
                </div>
                <div class="col-lg-6">
                    <label for="assigndate" class="form-label">Assign Date</label>
                    <input type="date" value="<?php echo $assignDate ?>" name="assigndate" id="assigndate"
                        class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0"
                        href="tap.php?studentid=<?php echo $studentid ?>">Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>