<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Status</title>
    <?php
        include("script.php");
        include("connection.php");

        // Fetch program IDs from the tblprogram table
        $sql = "SELECT programid FROM tblprogram";
        $result = mysqli_query($conn, $sql);
        $programids = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $programids[] = $row['programid'];
        }
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php
        include("admin_sidebar.php");
    ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form action="insert_studentstatus.php" method="POST">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Student Status
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student's ID</label>
                    <input type="text" class="form-control" name="studentid"
                        value="<?php echo isset($_GET['studentid']) ? $_GET['studentid'] : ''; ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="programid" class="form-label">Program ID:</label>
                    <select id="programid" name="programid" class="form-select" required>
                        <option value="">Select Program ID</option>
                        <?php foreach ($programids as $programid): ?>
                        <option value="<?php echo $programid; ?>"><?php echo $programid; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="assigned" class="form-label">Assigned:</label>
                    <input type="text" id="assigned" name="assigned" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="note" class="form-label">Note:</label>
                    <textarea id="note" name="note" class="form-control"></textarea>
                </div>

                <div class="col-lg-6">
                    <label for="assigndate" class="form-label">Assign Date:</label>
                    <input type="date" id="assigndate" name="assigndate" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <!-- <a class="btn bg-primary text-white m-0" href="display_student_status.php">Cancel</a> -->
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>