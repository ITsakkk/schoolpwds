<?php
// Include your database connection file
include("connection.php");

$query_lecturer_info = "
    SELECT
        l.*,
        s.sexen,
        n.nationalityen,
        c.countryen,
        d.degreenameen,
        dept.departmentname
    FROM 
        tbllecturer l
        LEFT JOIN tblsex s ON l.sexid = s.sexid
        LEFT JOIN tblnationality n ON l.nationalityid = n.nationalityid
        LEFT JOIN tblcountry c ON l.countryid = c.countryid
        LEFT JOIN tbldegree d ON l.degreeid = d.degreeid
        LEFT JOIN department dept ON l.departmentid = dept.departmentid
    WHERE 
        l.lecturerid = {$_GET['lecturerid']}
        AND statusid = 1;
    
";

$result_lecturer_info = mysqli_query($conn, $query_lecturer_info);
$lecturer_info = mysqli_fetch_assoc($result_lecturer_info);


$query_schedule_info = "
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
    s.lecturerid = ?
    AND s.statusid = 1 
ORDER BY
    s.scheduleid DESC
LIMIT 1";


 $stmt = mysqli_prepare($conn, $query_schedule_info);
 mysqli_stmt_bind_param($stmt, "i", $_GET['lecturerid']);
 mysqli_stmt_execute($stmt);
$result_schedule_info = mysqli_stmt_get_result($stmt);
$schedule_info = mysqli_fetch_assoc($result_schedule_info);


include("script.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
    /* Additional styles for better appearance */
    .tab-content {
        padding: 20px;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    /* Custom class to change background color of active tab */
    .nav-tabs .nav-item .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }

    . {
        border-radius: 50px 0 0 50px !important;
    }

    .rounded-right {
        border-radius: 0 50px 50px 0 !important;
    }

    .custom-circular-image {
        width: 240px;
        /* Set the width */
        height: 240px;
        /* Set the height */
    }
    </style>
</head>

<body>
    <!-- sidebar -->
    <?php
    include("admin_sidebar.php");
    ?>
    <!-- end of sidebar -->
    <div class="content px-2 pb-2">
        <ul class="nav nav-tabs pl-1" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link p-4 active" id="student-info-tab" data-toggle="tab" href="#student-info" role="tab"
                    aria-controls="student-info" aria-selected="true">Lecturer Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-4" id="student-status-tab" data-toggle="tab" href="#student-status" role="tab"
                    aria-controls="student-status-tab" aria-selected="false">Schedule</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link p-4" id="education-background-tab" data-toggle="tab" href="#education-background"
                    role="tab" aria-controls="education-background" aria-selected="false">Program</a>
            </li> -->
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="student-info" role="tabpanel" aria-labelledby="student-info-tab">
                <div class="row py-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Full Name</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['nameinlatin']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Birthday</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['dob']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Address</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['address']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Phone Number</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['phone']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Email</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['email']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4  text-end">
                                <img src="img/<?php echo $lecturer_info['photo']; ?>"
                                    class="img-fluid custom-circular-image" alt="Circular Image">
                            </div>
                            <div class="col-12 mb-4">
                                <a class="btn btn-outline-primary"
                                    href="edit_lecturer.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"><i
                                        class="fa-solid fa-pencil fs-sm-7"></i>
                                    Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 bg-primary text-white p-1 mb-4  pl-3 fs-4 mt-2">
                                <i class="fa-solid fa-user pr-1"></i>
                                Personal Information
                            </div>
                            <div class="col-12 ">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Lecturer's ID</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['lecturerid']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Name in Khmer</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['nameinkh']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Name in Latin</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['nameinlatin']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Family Name</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['familyname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Given Name</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['givenname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Sex</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['sexen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Passport ID</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['passportid']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Nationality</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['nationalityen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Country</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['countryen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Degree</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['degreenameen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Department</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['departmentname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Professional
                                            Experience</label>
                                        <p class="fs-5 text-dark">
                                            <?php echo $lecturer_info['professionalexperience']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Publications</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['publications']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Place Of Birth</label>
                                        <p class="fs-5 text-dark"><?php echo $lecturer_info['pob']; ?></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <a class="btn btn-outline-primary"
                                            href="edit_lecturer.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"><i
                                                class="fa-solid fa-pencil fs-sm-7"></i>
                                            Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Schedule
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <?php
                                    if(mysqli_num_rows($result_schedule_info) > 0) {
                                    ?>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Schedule ID</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['scheduleid']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Subject</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['subjecten']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Work's Day</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['daynameen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Time</label>
                                        <p class="fs-5 text-dark">
                                            <?php echo $schedule_info['starttime']; ?> -
                                            <?php echo $schedule_info['endtime']; ?>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Room</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['roomname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Data Start</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['datestart']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Date End</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['dateend']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Schedule Date</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['scheduledate']; ?></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <a class="btn btn-outline-primary"
                                            href="edit_shecdule.php?scheduleid=<?php echo $schedule_info['scheduleid'] ?>"><i
                                                class="fa-solid fa-pencil fs-sm-7"></i>
                                            Edit</a>
                                    </div>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">No Schedule
                                            available</label>
                                        <div class="col-12 py-2 p-0">
                                            <a href="form_shecdule.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"
                                                class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                                                Add Schedule</a>
                                        </div>
                                    </div>
                                    <?php
                                    };
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                                <i class="fa-solid fa-gear me-2"></i>
                                Program
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <?php
                                    if(mysqli_num_rows($result_schedule_info) > 0) {
                                    ?>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Program's ID</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['programid']; ?>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Year</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['yearen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Semester</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['semesteren']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Shift</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['shiften']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Degree</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['degreenameen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['academicyear']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Major</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['majoren']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Batch</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['batchen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Start Date</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['program_startdate']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">End Date</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['program_enddate']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Date Issue</label>
                                        <p class="fs-5 text-dark"><?php echo $schedule_info['program_dateissue']; ?></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <a class="btn btn-outline-primary"
                                            href="edit_shecdule.php?scheduleid=<?php echo $schedule_info['scheduleid'] ?>"><i
                                                class="fa-solid fa-pencil fs-sm-7"></i>
                                            Edit</a>
                                    </div>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">No Program
                                            available</label>
                                        <div class="col-12 py-2 p-0">
                                            <a href="form_shecdule.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"
                                                class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                                                Add Schedule</a>
                                        </div>
                                    </div>
                                    <?php
                                    };
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="student-status" role="tabpanel" aria-labelledby="student-status-tab">
                <?php
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
                   s.lecturerid = {$_GET['lecturerid']}
                   AND s.statusid = 1 
               ORDER BY
                   s.scheduleid DESC";
           
        
            // Execute the query
                $re_schedule = mysqli_query($conn, $schedule_query);
                ?>
                <div class="row">
                    <div class="col-12 py-2 p-0">
                        <a href="form_shecdule.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"
                            class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                            Add Schedule</a>
                        </a>
                    </div>
                </div>
                <?php
                    // Check if the query was successful
                    if($re_schedule) {
                    // Output the result (you can customize this part based on your HTML structure)
                    while ($row_schedule = mysqli_fetch_assoc($re_schedule)) {
                    ?>
                <div class="row">
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
                        <p class="fs-5 text-dark"><?php echo $schedule_info['datestart']; ?></p>
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
                        <a class="btn btn-outline-primary"
                            href="edit_shecdule.php?scheduleid=<?php echo $row_schedule['scheduleid'] ?>"><i
                                class="fa-solid fa-pencil fs-sm-7"></i>
                            Edit</a> <a class="btn btn-outline-danger"
                            href="delete_shecdule.php?scheduleid=<?php echo $row_schedule['scheduleid'] ?>"><i
                                class="fa-solid fa-trash-can fs-sm-7"></i> Delete</a>
                    </div>
                </div>
                <?php
                }
            }
            ?>
            </div>
        </div>
    </div>

</body>

</html>