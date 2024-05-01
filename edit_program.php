<?php
include("connection.php");

// Check if programid is provided
if(isset($_GET['programid'])) {
    $programid = $_GET['programid'];
    
    // Query to retrieve program details
    $query = "SELECT
                    p.programid,
                    ay.academicyear,
                    y.yearen,
                    s.semesteren,
                    sh.shiften,
                    d.degreenameen,
                    m.majoren,
                    b.batchen,
                    p.startdate,
                    p.enddate,
                    p.dateissue
                FROM
                    tblprogram p
                LEFT JOIN
                    tblacademicyear ay ON p.academicyearid = ay.academicyearid
                LEFT JOIN
                    tblyear y ON p.yearid = y.yearid
                LEFT JOIN
                    tblsemester s ON p.semesterid = s.semesterid
                LEFT JOIN
                    tblshift sh ON p.shiftid = sh.shiftid
                LEFT JOIN
                    tbldegree d ON p.degreeid = d.degreeid
                LEFT JOIN
                    tblmajor m ON p.majorid = m.majorid
                LEFT JOIN
                    tblbatch b ON p.batchid = b.batchid
                WHERE
                    p.programid = $programid";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "No data found for the specified program ID.";
        exit;
    }
} else {
    if (!empty($_POST["programid"])) {
        // Retrieve form data
        $programid = $_POST["programid"];
        $yearid = $_POST["yearid"];
        $semesterid = $_POST["semesterid"];
        $shiftid = $_POST["shiftid"];
        $degreeid = $_POST["degreeid"];
        $academicyearid = $_POST["academicyearid"];
        $majorid = $_POST["majorid"];
        $batchid = $_POST["batchid"];
        $startdate = $_POST["startdate"];
        $enddate = $_POST["enddate"];
        $dateissue = $_POST["dateissue"];

        // Update program details in database
        $query = "UPDATE tblprogram 
                    SET yearid = '$yearid',
                        semesterid = '$semesterid',
                        shiftid = '$shiftid',
                        degreeid = '$degreeid',
                        academicyearid = '$academicyearid',
                        majorid = '$majorid',
                        batchid = '$batchid',
                        startdate = '$startdate',
                        enddate = '$enddate',
                        dateissue = '$dateissue'
                    WHERE programid = $programid";

        if (mysqli_query($conn, $query)) {
            header("location: display_program.php");
        } else {
            echo "Error updating program details: " . mysqli_error($conn);
        }
    }
}

// Query to retrieve academic years for select options
$queryAcademicYears = "SELECT academicyearid, academicyear FROM tblacademicyear";
$resultAcademicYears = mysqli_query($conn, $queryAcademicYears);

// Query to retrieve years for select options
$queryYears = "SELECT yearid, yearen FROM tblyear";
$resultYears = mysqli_query($conn, $queryYears);

// Query to retrieve semesters for select options
$querySemesters = "SELECT semesterid, semesteren FROM tblsemester";
$resultSemesters = mysqli_query($conn, $querySemesters);

// Query to retrieve shifts for select options
$queryShifts = "SELECT shiftid, shiften FROM tblshift";
$resultShifts = mysqli_query($conn, $queryShifts);

// Query to retrieve degrees for select options
$queryDegrees = "SELECT degreeid, degreenameen FROM tbldegree";
$resultDegrees = mysqli_query($conn, $queryDegrees);

// Query to retrieve majors for select options
$queryMajors = "SELECT majorid, majoren FROM tblmajor";
$resultMajors = mysqli_query($conn, $queryMajors);

// Query to retrieve batches for select options
$queryBatches = "SELECT batchid, batchen FROM tblbatch";
$resultBatches = mysqli_query($conn, $queryBatches);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
    <?php include("script.php"); ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4 pb-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Program
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="yearen" class="form-label">Year</label>
                    <select id="yearen" name="yearid" class="form-select" required>
                        <?php
        while ($rowYear = mysqli_fetch_assoc($resultYears)) {
            $selected = ($row['yearen'] == $rowYear['yearen']) ? 'selected' : '';
            echo "<option value='{$rowYear['yearid']}' $selected>{$rowYear['yearen']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="semesteren" class="form-label">Semester</label>
                    <select id="semesteren" name="semesterid" class="form-select" required>
                        <?php
        while ($rowSemester = mysqli_fetch_assoc($resultSemesters)) {
            $selected = ($row['semesteren'] == $rowSemester['semesteren']) ? 'selected' : '';
            echo "<option value='{$rowSemester['semesterid']}' $selected>{$rowSemester['semesteren']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="shiften" class="form-label">Shift</label>
                    <select id="shiften" name="shiftid" class="form-select" required>
                        <?php
        while ($rowShift = mysqli_fetch_assoc($resultShifts)) {
            $selected = ($row['shiften'] == $rowShift['shiften']) ? 'selected' : '';
            echo "<option value='{$rowShift['shiftid']}' $selected>{$rowShift['shiften']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="degreenameen" class="form-label">Degree</label>
                    <select id="degreenameen" name="degreeid" class="form-select" required>
                        <?php
        while ($rowDegree = mysqli_fetch_assoc($resultDegrees)) {
            $selected = ($row['degreenameen'] == $rowDegree['degreenameen']) ? 'selected' : '';
            echo "<option value='{$rowDegree['degreeid']}' $selected>{$rowDegree['degreenameen']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="academicyear" class="form-label">Academic Year</label>
                    <select id="academicyear" name="academicyearid" class="form-select" required>
                        <?php
        while ($rowAcademicYear = mysqli_fetch_assoc($resultAcademicYears)) {
            $selected = ($row['academicyear'] == $rowAcademicYear['academicyear']) ? 'selected' : '';
            echo "<option value='{$rowAcademicYear['academicyearid']}' $selected>{$rowAcademicYear['academicyear']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="majoren" class="form-label">Major</label>
                    <select id="majoren" name="majorid" class="form-select" required>
                        <?php
        while ($rowMajor = mysqli_fetch_assoc($resultMajors)) {
            $selected = ($row['majoren'] == $rowMajor['majoren']) ? 'selected' : '';
            echo "<option value='{$rowMajor['majorid']}' $selected>{$rowMajor['majoren']}</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="batchen" class="form-label">Batch</label>
                    <select id="batchen" name="batchid" class="form-select" required>
                        <?php
        while ($rowBatch = mysqli_fetch_assoc($resultBatches)) {
            $selected = ($row['batchen'] == $rowBatch['batchen']) ? 'selected' : '';
            echo "<option value='{$rowBatch['batchid']}' $selected>{$rowBatch['batchen']}</option>";
        }
        ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="startdate" class="form-label">Start Date</label>
                    <input type="date" id="startdate" name="startdate" class="form-control"
                        value="<?php echo $row['startdate']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="enddate" class="form-label">End Date</label>
                    <input type="date" id="enddate" name="enddate" class="form-control"
                        value="<?php echo $row['enddate']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="dateissue" class="form-label">Date Issue</label>
                    <input type="date" id="dateissue" name="dateissue" class="form-control"
                        value="<?php echo $row['dateissue']; ?>">
                </div>
                <input type="hidden" name="programid" value="<?php echo $row['programid']; ?>">
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_program.php">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>