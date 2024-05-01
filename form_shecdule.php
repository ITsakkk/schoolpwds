<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <?php
    include("script.php");
    include("connection.php");
    $query_program = "
    SELECT
        p.*,
        yr.yearen,
        sem.semesteren,
        sh.shiften
    FROM
        tblprogram p
    LEFT JOIN
        tblyear yr ON p.yearid = yr.yearid
    LEFT JOIN
        tblsemester sem ON p.semesterid = sem.semesterid
    LEFT JOIN
        tblshift sh ON p.shiftid = sh.shiftid
    LEFT JOIN
        tbldegree deg ON p.degreeid = deg.degreeid";

// Fetch data for select options from related tables
$result_program = mysqli_query($conn, $query_program);

    
    $query_subject = "SELECT subjectid, subjecten FROM tblsubject";
    $result_subject = mysqli_query($conn, $query_subject);

    $query_dayweek = "SELECT dayweekid, daynameen FROM tbldayweek";
    $result_dayweek = mysqli_query($conn, $query_dayweek);

    $query_time = "SELECT timeid, starttime, endtime FROM tbltime";
    $result_time = mysqli_query($conn, $query_time);

    $query_room = "SELECT roomid, roomname FROM tblroom";
    $result_room = mysqli_query($conn, $query_room);
    $sql_status = "SELECT * FROM tblstatus";
    $result_status = mysqli_query($conn, $sql_status);
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4 pb-2">
        <form action="insert_shedule.php" method="POST">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Schedule
                </div>
            </div>
            <div class="row py-4 bg-light">
                <?php
                if(isset($_GET['lecturerid'])) {
                ?>
                <div class="col-lg-6">
                    <label for="lecturerid" class="form-label">Lecturer's ID</label>
                    <input type="text" class="form-control" name="lecturerid"
                        value="<?php echo isset($_GET['lecturerid']) ? $_GET['lecturerid'] : ''; ?>" readonly>
                </div>
                <?php
                }else {
                 ?>
                <div class="col-lg-6">
                    <label for="lecturerid" class="form-label">Lecturer's ID</label>
                    <input type="text" class="form-control" name="lecturerid">
                </div>
                <?php
                }
                ?>
                <div class="col-lg-6">
                    <label for="subjectid" class="form-label">Subject</label>
                    <select id="subjectid" name="subjectid" class="form-select">
                        <option value="">Select Subject</option>
                        <?php
                        while ($row_subject = mysqli_fetch_assoc($result_subject)) {
                            echo "<option value='{$row_subject['subjectid']}'>{$row_subject['subjecten']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="programid" class="form-label">Program</label>
                    <select id="programid" name="programid" class="form-select">
                        <option value="">Select Program</option>
                        <?php
                        while ($row_program = mysqli_fetch_assoc($result_program)) {
                            echo "<option value='{$row_program['programid']}'>Program {$row_program['programid']}, {$row_program['yearen']}, {$row_program['semesteren']}, {$row_program['shiften']} </option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="dayweekid" class="form-label">Day of the Week</label>
                    <select id="dayweekid" name="dayweekid" class="form-select">
                        <option value="">Select Day</option>
                        <?php
                        while ($row_dayweek = mysqli_fetch_assoc($result_dayweek)) {
                            echo "<option value='{$row_dayweek['dayweekid']}'>{$row_dayweek['daynameen']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="timeid" class="form-label">Time</label>
                    <select id="timeid" name="timeid" class="form-select">
                        <option value="">Select Time</option>
                        <?php
        while ($row_time = mysqli_fetch_assoc($result_time)) {
            echo "<option value='{$row_time['timeid']}'>{$row_time['starttime']} - {$row_time['endtime']}</option>";
        }
        ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="roomid" class="form-label">Room</label>
                    <select id="roomid" name="roomid" class="form-select">
                        <option value="">Select Room</option>
                        <?php
                        while ($row_room = mysqli_fetch_assoc($result_room)) {
                            echo "<option value='{$row_room['roomid']}'>{$row_room['roomname']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="datestart" class="form-label">Start Date</label>
                    <input type="date" id="datestart" name="datestart" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="dateend" class="form-label">End Date</label>
                    <input type="date" id="dateend" name="dateend" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="scheduledate" class="form-label">Schedule Date</label>
                    <input type="date" id="scheduledate" name="scheduledate" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="statusid" class="form-label">Status</label>
                    <select id="statusid" name="statusid" class="form-select" required>
                        <option value="">Select Status</option>
                        <?php
                        // Generate options for Status dropdown
                        while ($row = mysqli_fetch_assoc($result_status)) {
                            echo "<option value='{$row['statusid']}'>{$row['description']}</option>";
                        }
                        ?>
                    </select>
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