<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>faculty, major, and Commune Selection</title>
    <?php
        include("script.php");
        include("connection.php");
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php
    include("admin_sidebar.php");
    ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form action="insert_edubackground.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Education Background
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student's ID</label>
                    <input type="text" class="form-control" name="studentid"
                        value="<?php echo isset($_GET['studentid']) ? $_GET['studentid'] : ''; ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="nameschool" class="form-label">School's Name</label>
                    <input type="text" id="nameschool" name="nameschool" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="schooltypeen" class="form-label">School's Type</label>
                    <select id="schooltypeen" name="schooltypeid" class="form-select" required>
                        <option value="">Select School's Type</option>
                        <?php
                $query = "SELECT schooltypeid, schooltypeen FROM tblschooltype";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['schooltypeid']}'>{$row['schooltypeen']}</option>";
                }
                ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="academicyear" class="form-label">Academic Year</label>
                    <input type="text" id="academicyear" name="academicyear" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" id="province" name="province" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <!-- <a class="btn bg-primary text-white m-0" href="display_edubackground.php">
                        Cancel</a> -->
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
</body>

</html>