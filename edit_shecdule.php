<?php
include("connection.php");

$query_subject = "SELECT subjectid, subjecten FROM tblsubject";
$result_subject = mysqli_query($conn, $query_subject);

$query_program = "SELECT programid FROM tblprogram";
$result_program = mysqli_query($conn, $query_program);

$query_dayweek = "SELECT dayweekid, daynameen FROM tbldayweek";
$result_dayweek = mysqli_query($conn, $query_dayweek);

$query_time = "SELECT timeid, starttime, endtime FROM tbltime";
$result_time = mysqli_query($conn, $query_time);

$query_room = "SELECT roomid, roomname FROM tblroom";
$result_room = mysqli_query($conn, $query_room);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Retrieve data from the database
    if (!isset($_GET['scheduleid'])) {
        header("Location: display_shecdule.php");
        exit;
    }

    $scheduleid = $_GET['scheduleid'];
    // Retrieve schedule data from the database
    $query_schedule = "SELECT * FROM tblschedule WHERE scheduleid = $scheduleid";
    $result_schedule = mysqli_query($conn, $query_schedule);
    $row_schedule = mysqli_fetch_assoc($result_schedule);

    if (!$row_schedule) {
        header("Location: display_shecdule.php");
        exit;
    }

    // Extract schedule data
    $scheduleid = $row_schedule['scheduleid'];
    $subjectid = $row_schedule['subjectid'];
    $lecturerid = $row_schedule['lecturerid'];
    $dayweekid = $row_schedule['dayweekid'];
    $timeid = $row_schedule['timeid'];
    $roomid = $row_schedule['roomid'];
    $programid = $row_schedule['programid'];
    $datestart = $row_schedule['datestart'];
    $dateend = $row_schedule['dateend'];
    $scheduledate = $row_schedule['scheduledate'];
    $statusid = $row_schedule['statusid'];

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update schedule data in the database
    $scheduleid = $_POST['scheduleid'];
    $subjectid = $_POST['subjectid'];
    $lecturerid = $_POST['lecturerid'];
    $dayweekid = $_POST['dayweekid'];
    $timeid = $_POST['timeid'];
    $roomid = $_POST['roomid'];
    $programid = $_POST['programid'];
    $datestart = $_POST['datestart'];
    $dateend = $_POST['dateend'];
    $scheduledate = $_POST['scheduledate'];
    $statusid = $_POST['statusid'];

    $sql_update_schedule = "UPDATE tblschedule SET subjectid='$subjectid', lecturerid='$lecturerid', dayweekid='$dayweekid', timeid='$timeid', roomid='$roomid', programid='$programid', datestart='$datestart', dateend='$dateend', scheduledate='$scheduledate', statusid='$statusid' WHERE scheduleid = $scheduleid";
    // $result_update_schedule = mysqli_query($conn, $sql_update_schedule);

    if (mysqli_query($conn, $sql_update_schedule)) {
        if ($statusid == 1) {
            header("Location: tap_lecturer.php?lecturerid=$lecturerid");
        } elseif ($statusid == 2) {
            header("Location: display_shecdule.php");
        }
    } else {
        echo "Error updating program details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
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
                    Edit Schedule
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="lecturerid" class="form-label">Lecturer's ID</label>
                    <input type="text" class="form-control" name="lecturerid" value="<?php echo $lecturerid; ?>"
                        readonly>
                </div>
                <div class="col-lg-6">
                    <label for="scheduleid" class="form-label">Schedule's ID</label>
                    <input type="text" class="form-control" name="scheduleid" value="<?php echo $scheduleid; ?>"
                        readonly>
                </div>
                <div class="col-lg-6">
                    <label for="subjectid" class="form-label">Subject</label>
                    <select id="subjectid" name="subjectid" class="form-select">
                        <option value="">Select Subject</option>
                        <?php
        while ($row_subject = mysqli_fetch_assoc($result_subject)) {
            $selected = ($row_subject['subjectid'] == $subjectid) ? 'selected' : '';
            echo "<option value='{$row_subject['subjectid']}' $selected>{$row_subject['subjecten']}</option>";
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
                            $selected = ($programid == $row_program['programid']) ? 'selected' : '';
                            echo "<option value='{$row_program['programid']}' $selected>{$row_program['programid']}</option>";
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
                            $selected = ($dayweekid == $row_dayweek['dayweekid']) ? 'selected' : '';
                            echo "<option value='{$row_dayweek['dayweekid']}' $selected>{$row_dayweek['daynameen']}</option>";
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
                            $selected = ($timeid == $row_time['timeid']) ? 'selected' : '';
                            echo "<option value='{$row_time['timeid']}' $selected>{$row_time['starttime']} - {$row_time['endtime']}</option>";
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
                            $selected = ($roomid == $row_room['roomid']) ? 'selected' : '';
                            echo "<option value='{$row_room['roomid']}' $selected>{$row_room['roomname']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="datestart" class="form-label">Start Date</label>
                    <input type="date" id="datestart" name="datestart" class="form-control"
                        value="<?php echo $datestart; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="dateend" class="form-label">End Date</label>
                    <input type="date" id="dateend" name="dateend" class="form-control" value="<?php echo $dateend; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="scheduledate" class="form-label">Schedule Date</label>
                    <input type="date" id="scheduledate" name="scheduledate" class="form-control"
                        value="<?php echo $scheduledate; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="statusid" class="form-label">Status</label>
                    <select name="statusid" id="statusid" class="form-control">
                        <option value="1" <?php if($statusid == 1) echo 'selected'; ?>>enable</option>
                        <option value="2" <?php if($statusid == 2) echo 'selected'; ?>>disable</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0"
                        href="tap_lecturer.php?lecturerid=<?php echo $lecturerid ?>">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

</body>

</html>