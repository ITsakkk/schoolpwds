<?php
include("script.php");
include("connection.php");
?>
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
                ss.studentstatusid,
                ss.assigned,
                ss.note,
                ss.assigndate,
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
                tblstudentstatus ss ON p.programid = ss.programid
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
                s.lecturerid = 11}
                ORDER BY
                    s.scheduleid DESC";
        
            // Execute the query
                $re_schedule = mysqli_query($conn, $schedule_query);
                ?>
<!-- <div class="row">
        <div class="col-12 py-2 p-0">
            <a href="form_shecdule.php?lecturerid=<?php echo $lecturer_info['lecturerid'] ?>"
                class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                Add New</a>
        </div>
    </div> -->
<?php
                    // Check if the query was successful
                    if($re_schedule) {
                    // Output the result (you can customize this part based on your HTML structure)
                    while ($row_schedule = mysqli_fetch_assoc($re_schedule)) {
                    ?>
<div class="row">
    <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
        <i class="fa-solid fa-gear"></i>
        Schedule
        <?php echo $row_schedule['scheduleid']; ?></span>
    </div>
    <div class="col-4">
        <label for="" class="form-label fs-5 text-dark fw-bold">Major</label>
        <p class="fs-5 text-dark"><?php echo $row_schedule['majoren']; ?></p>
    </div>
    <div class="col-12 mb-4">
        <a class="btn btn-outline-primary"
            href="edit_studentstatus.php?studentstatusid=<?php echo $row_schedule['studentstatusid'] ?>"><i
                class="fa-solid fa-pencil fs-sm-7"></i>
            Edit</a>
    </div>
</div>
<?php
                }
            }
            ?>