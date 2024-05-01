<?php
include("connection.php");

// Pagination variables
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search_id = isset($_GET['search_id']) ? $_GET['search_id'] : '';

// Modify the SQL query to select student information
$schedule_query = "
SELECT
    s.scheduleid,
    lc.nameinlatin,
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
    tbllecturer lc ON s.lecturerid = lc.lecturerid
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
    s.statusid = 1";

// Add search condition
if (!empty($search_id)) {
    $schedule_query .= " AND s.scheduleid = $search_id";
}

// Add pagination
$schedule_query .= " LIMIT $start, $limit";

$rs_result = mysqli_query($conn, $schedule_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Students</title>
    <?php include("script.php"); ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content -->
    <div class="content px-4">
        <!-- Search Form -->
        <div class="row">
            <div class="col-lg-3 py-2 p-0 text-start">
                <form class="form-inline" id="searchForm" action="display_shecdule.php" method="GET">
                    <div class="form-group rounded border border-primary">
                        <input class="form-control mr-sm-2 border-0 outline-0" type="text" name="search_id"
                            placeholder="Search by ID..." aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0 border-0 rounded-0" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-3 py-2 p-0 text-start">
                <a href="display_shecdule.php" class="btn btn-primary "><i class="fa-solid fa-arrows-rotate"></i>
                    Refresh</a>
            </div>
            <div class="col-6 py-2 p-0 text-end">
                <a href="form_shecdule.php" class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                    Add New</a>
            </div>
        </div>

        <!-- Student Table -->
        <div class="row d-flex align-items-center p-3 bg-primary text-white">
            <!-- Table Headers -->
            <div class="col-lg-1 fs-5 font-weight-bold">ID</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Subject</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Lecturer's ID</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Lecturer's Name</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Day</div>
            <div class="col-lg-1 fs-5 font-weight-bold">Room</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Actions</div>
        </div>

        <!-- Display Student Data -->
        <?php
        $bg_color_class = 'DFDFDF';
        if (mysqli_num_rows($rs_result) > 0) {
            while ($row = mysqli_fetch_array($rs_result)) {
                $bg_color_class = ($bg_color_class == 'DFDFDF') ? 'bg-white' : 'DFDFDF';
        ?>
        <div class="row d-flex align-items-center p-2 border DFDFDF <?php echo $bg_color_class; ?>">
            <!-- Display Student Information -->
            <div class="col-lg-1 font-weight-bold text-truncate"><?php echo $row['scheduleid'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['subjecten'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['lecturerid'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['nameinlatin'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['daynameen'] ?></div>
            <div class="col-lg-1 text-truncate"><?php echo $row['roomname'] ?></div>

            <!-- Action Buttons -->
            <div class="col-lg-2 fs-5">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="seeMoreDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="seeMoreDropdown">
                        <li><a class="dropdown-item"
                                href="edit_shecdule.php?scheduleid=<?php echo $row['scheduleid'] ?>"><i
                                    class="fa-solid fa-pencil fs-sm-7"></i> Edit</a></li>
                        <li><a class="dropdown-item"
                                href="view_shecdule.php?scheduleid=<?php echo $row['scheduleid'] ?>"><i
                                    class="fa-solid fa-magnifying-glass fs-sm-7"></i> View Form</a></li>
                        <li><a class="dropdown-item text-danger"
                                href="delete_shecdule.php?scheduleid=<?php echo $row['scheduleid'] ?>"><i
                                    class="fa-solid fa-trash-can fs-sm-7"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
        ?>
        <!-- No Results Message -->
        <div class="row d-flex align-items-center p-2 border bg-warning">
            <div class='col-lg-12 text-white'>
                No results found.
            </div>
        </div>
        <?php
        }

        // Pagination Links
        $query = "SELECT COUNT(*) AS count FROM tblschedule WHERE statusid = 1";
        $rs_result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs_result);
        $total_records = $row['count'];
        $total_pages = ceil($total_records / $limit);

        echo "<div class='row p-0 py-2'>";
        echo "<ul class='pagination m-0 p-0'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link fs-5 p-2 px-3 text-primary bg-light border-primary' href='?page=" . $i . "&search_id=" . $search_id . "'>" . $i . "</a></li>";
        }
        echo "</ul>";
        echo "</div>";
        ?>
    </div>
</body>

</html>