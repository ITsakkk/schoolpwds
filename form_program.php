<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Program</title>
    <?php
    include("script.php");
    include("connection.php");

    // Fetch data for select options from related tables
    $query_year = "SELECT yearid, yearen FROM tblyear";
    $result_year = mysqli_query($conn, $query_year);

    $query_semester = "SELECT semesterid, semesteren FROM tblsemester";
    $result_semester = mysqli_query($conn, $query_semester);

    $query_shift = "SELECT shiftid, shiften FROM tblshift";
    $result_shift = mysqli_query($conn, $query_shift);

    $query_degree = "SELECT degreeid, degreenameen FROM tbldegree";
    $result_degree = mysqli_query($conn, $query_degree);

    $query_academicyear = "SELECT academicyearid, academicyear FROM tblacademicyear";
    $result_academicyear = mysqli_query($conn, $query_academicyear);

    $query_major = "SELECT majorid, majoren FROM tblmajor";
    $result_major = mysqli_query($conn, $query_major);

    $query_batch = "SELECT batchid, batchen FROM tblbatch";
    $result_batch = mysqli_query($conn, $query_batch);
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4 pb-2">
        <form action="insert_program.php" method="POST">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Program
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="yearid" class="form-label">Year</label>
                    <select id="yearid" name="yearid" class="form-select">
                        <option value="">Select Year</option>
                        <?php
                        while ($row_year = mysqli_fetch_assoc($result_year)) {
                            echo "<option value='{$row_year['yearid']}'>{$row_year['yearen']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="semesterid" class="form-label">Semester</label>
                    <select id="semesterid" name="semesterid" class="form-select">
                        <option value="">Select Semester</option>
                        <?php
                        while ($row_semester = mysqli_fetch_assoc($result_semester)) {
                            echo "<option value='{$row_semester['semesterid']}'>{$row_semester['semesteren']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="shiftid" class="form-label">Shift</label>
                    <select id="shiftid" name="shiftid" class="form-select">
                        <option value="">Select Shift</option>
                        <?php
                        while ($row_shift = mysqli_fetch_assoc($result_shift)) {
                            echo "<option value='{$row_shift['shiftid']}'>{$row_shift['shiften']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="degreeid" class="form-label">Degree</label>
                    <select id="degreeid" name="degreeid" class="form-select">
                        <option value="">Select Degree</option>
                        <?php
                        while ($row_degree = mysqli_fetch_assoc($result_degree)) {
                            echo "<option value='{$row_degree['degreeid']}'>{$row_degree['degreenameen']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="academicyearid" class="form-label">Academic Year</label>
                    <select id="academicyearid" name="academicyearid" class="form-select">
                        <option value="">Select Academic Year</option>
                        <?php
                        while ($row_academicyear = mysqli_fetch_assoc($result_academicyear)) {
                            echo "<option value='{$row_academicyear['academicyearid']}'>{$row_academicyear['academicyear']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="majorid" class="form-label">Major</label>
                    <select id="majorid" name="majorid" class="form-select">
                        <option value="">Select Major</option>
                        <?php
                        while ($row_major = mysqli_fetch_assoc($result_major)) {
                            echo "<option value='{$row_major['majorid']}'>{$row_major['majoren']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="batchid" class="form-label">Batch</label>
                    <select id="batchid" name="batchid" class="form-select">
                        <option value="">Select Batch</option>
                        <?php
                        while ($row_batch = mysqli_fetch_assoc($result_batch)) {
                            echo "<option value='{$row_batch['batchid']}'>{$row_batch['batchen']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="startdate" class="form-label">Start Date</label>
                    <input type="date" id="startdate" name="startdate" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="enddate" class="form-label">End Date</label>
                    <input type="date" id="enddate" name="enddate" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="dateissue" class="form-label">Date Issue</label>
                    <input type="date" id="dateissue" name="dateissue" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_program.php">
                        Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>