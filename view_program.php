<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Program</title>
    <?php
    include("script.php");
    include("connection.php");

    // Check if programid is provided
    if(isset($_GET['programid'])) {
        $programid = $_GET['programid'];
        
        // Query to fetch program details
        $query = "SELECT
            p.programid,
            y.yearen,
            s.semesteren,
            sh.shiften,
            d.degreenameen,
            ay.academicyear,
            m.majoren,
            b.batchen,
            p.startdate,
            p.enddate,
            p.dateissue
        FROM
            tblprogram p
        LEFT JOIN
            tblyear y ON p.yearid = y.yearid
        LEFT JOIN
            tblsemester s ON p.semesterid = s.semesterid
        LEFT JOIN
            tblshift sh ON p.shiftid = sh.shiftid
        LEFT JOIN
            tbldegree d ON p.degreeid = d.degreeid
        LEFT JOIN
            tblacademicyear ay ON p.academicyearid = ay.academicyearid
        LEFT JOIN
            tblmajor m ON p.majorid = m.majorid
        LEFT JOIN
            tblbatch b ON p.batchid = b.batchid
        WHERE
            p.programid = $programid";

        $result = mysqli_query($conn, $query);

        // Check if data exists
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "No data found for the specified program ID.";
            exit;
        }
    } else {
        echo "Program ID not provided.";
        exit;
    }
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
                View Program
            </div>
        </div>
        <div class="row py-4 bg-light">
            <div class="col-5">
                <label for="" class="form-label fs-2">Program ID</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['programid']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Year</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['yearen']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Semester</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['semesteren']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Shift</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['shiften']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Degree</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['degreenameen']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Academic Year</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['academicyear']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Major</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['majoren']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Batch</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['batchen']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Start Date</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['startdate']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">End Date</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['enddate']; ?></p>
            </div>
            <div class="col-5">
                <label for="" class="form-label fs-2">Date Issued</label>
            </div>
            <div class="col-7">
                <p class="fs-3">: <?php echo $row['dateissue']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 p-0 py-2">
                <a class="btn bg-primary text-white m-0" href="display_program.php">Back</a>
                <a class="btn bg-primary text-white m-0"
                    href="edit_program.php?programid=<?php echo $row['programid']; ?>">Edit</a>
            </div>
        </div>
    </div>
    <!-- end of content -->
</body>

</html>