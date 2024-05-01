<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <?php
    include("script.php");
    include("connection.php");
    $schedule_query = "
    SELECT
        s.scheduleid,
        sub.subjecten,
        s.lecturerid,
        s.dayweekid,
        s.timeid,
        s.roomid,
        s.programid,
        s.datestart,
        s.dateend,
        s.scheduledate,
        yr.yearen,
        sem.semesteren,
        sh.shiften,
        deg.degreenameen,
        acy.academicyear,
        maj.majoren,
        bat.batchen,
        p.startdate AS program_startdate,
        p.enddate AS program_enddate,
        p.dateissue AS program_dateissue,
        dw.daynameen,
        t.starttime,
        t.endtime,
        r.roomname
    FROM
        tblschedule s
    INNER JOIN
        tblprogram p ON s.programid = p.programid
    LEFT JOIN
        tblyear yr ON p.yearid = yr.yearid
    LEFT JOIN
        tblsemester sem ON p.semesterid = sem.semesterid
    LEFT JOIN
        tblshift sh ON p.shiftid = sh.shiftid
    LEFT JOIN
        tbldegree deg ON p.degreeid = deg.degreeid
    LEFT JOIN
        tblsubject sub ON s.subjectid = sub.subjectid
    LEFT JOIN
        tbldayweek dw ON s.dayweekid = dw.dayweekid
    LEFT JOIN
        tbltime t ON s.timeid = t.timeid
    LEFT JOIN
        tblroom r ON s.roomid = r.roomid
    LEFT JOIN
        tblacademicyear acy ON p.academicyearid = acy.academicyearid
    LEFT JOIN
        tblmajor maj ON p.majorid = maj.majorid
    LEFT JOIN
        tblbatch bat ON p.batchid = bat.batchid
    WHERE
        s.scheduleid = {$_GET['scheduleid']}
        AND s.statusid = 1";

 // Execute the query
 $result_lecturer_info = mysqli_query($conn, $schedule_query);
 $row_schedule = mysqli_fetch_assoc($result_lecturer_info);
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4 pb-2">
        <div class="row">
            <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                View Schedule
            </div>
        </div>
        <div class="row py-4">
            <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                <i class="fas fa-calendar-alt me-2"></i>
                Schedule
                <?php echo $row_schedule['scheduleid']; ?></span>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Schedule ID</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['scheduleid']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Subject</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['subjecten']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Work's Day</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['daynameen']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Time</label>
                <p class="fs-5 text-dark">
                    <?php echo $row_schedule['starttime']; ?> -
                    <?php echo $row_schedule['endtime']; ?>
                </p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Room</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['roomname']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Data Start</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['datestart']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Date End</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['dateend']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Schedule Date</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['scheduledate']; ?></p>
            </div>
            <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                <i class="fa-solid fa-gear me-2"></i>
                Program
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Program's ID</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['programid']; ?>
                </p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Year</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['yearen']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Semester</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['semesteren']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Shift</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['shiften']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Degree</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['degreenameen']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['academicyear']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Major</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['majoren']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Batch</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['batchen']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Start Date</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['program_startdate']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">End Date</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['program_enddate']; ?></p>
            </div>
            <div class="col-4">
                <label for="" class="form-label fs-5 text-dark fw-bold">Date Issue</label>
                <p class="fs-5 text-dark"><?php echo $row_schedule['program_dateissue']; ?></p>
            </div>
            <div class="col-12 mb-4">
                <a class="btn btn-outline-primary" href="display_shecdule.php">Cancel</a>
                <a class="btn btn-outline-primary"
                    href="edit_shecdule.php?scheduleid=<?php echo $row_schedule['scheduleid'] ?>">
                    Edit</a>
            </div>
        </div>
    </div>
</body>

</html>