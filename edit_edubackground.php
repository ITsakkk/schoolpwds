<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Education Background</title>
    <?php
        include("script.php");
        include("connection.php");

        // Check if educational background ID is provided
        if(isset($_GET['studentid'])) {
            $studentid = $_GET['studentid'];

            // Retrieve educational background data based on ID
            $query = "SELECT * FROM tbleducationalbackground WHERE studentid = $studentid";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // Check if data is found
            if(!$row) {
                echo "<script>alert('Educational background not found!');</script>";
                echo "<script>window.location.href = 'Location: tap.php?studentid=$studentid';</script>";
            }
        } else {
            echo "<script>alert('Educational background ID not provided!');</script>";
            echo "<script>window.location.href = 'Location: tap.php?studentid=$studentid';</script>";
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Initialize variables with form data
            $nameschool = $_POST['nameschool'];
            $schooltypeen = $_POST['schooltypeen'];
            $academicyear = $_POST['academicyear'];
            $province = $_POST['province'];
            $studentid = $_POST['studentid'];

            // Prepare the SQL statement for update
            $query = "UPDATE tbleducationalbackground 
                      SET nameschool = '$nameschool', schooltypeid = '$schooltypeen', academicyear = '$academicyear', province = '$province'
                      WHERE studentid = $studentid";

            // Execute the SQL statement
            if (mysqli_query($conn, $query)) {
                header("Location: tap.php?studentid=$studentid");
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Education Background
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student's ID</label>
                    <input type="text" id="studentid" name="studentid" class="form-control"
                        value="<?php echo $row['studentid']; ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="nameschool" class="form-label">School's Name</label>
                    <input type="text" id="nameschool" name="nameschool" class="form-control"
                        value="<?php echo $row['nameschool']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="schooltypeen" class="form-label">School's Type</label>
                    <select id="schooltypeen" name="schooltypeen" class="form-select" required>
                        <option value="">Select School's Type</option>
                        <?php
                $query = "SELECT schooltypeid, schooltypeen FROM tblschooltype";
                $result = mysqli_query($conn, $query);
                while ($schooltype = mysqli_fetch_assoc($result)) {
                    $selected = ($row['schooltypeid'] == $schooltype['schooltypeid']) ? "selected" : "";
                    echo "<option value='{$schooltype['schooltypeid']}' $selected>{$schooltype['schooltypeen']}</option>";
                }
                ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="academicyear" class="form-label">Academic Year</label>
                    <input type="text" id="academicyear" name="academicyear" class="form-control"
                        value="<?php echo $row['academicyear']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" id="province" name="province" class="form-control"
                        value="<?php echo $row['province']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0"
                        href="tap.php?studentid=<?php echo $studentid ?>">Cancel</a>
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
</body>

</html>