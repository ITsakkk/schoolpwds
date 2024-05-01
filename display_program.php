<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    include("script.php");
    include("connection.php");
    $message = "";

    // Pagination variables
    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // Search
    $search_id = isset($_GET['search_id']) ? $_GET['search_id'] : '';

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
    tblbatch b ON p.batchid = b.batchid";


    // Add search condition
    if (!empty($search_id)) {
    $query .= " WHERE eb.programid = $search_id";
    }

    // Add pagination
    $query .= " LIMIT $start, $limit";

    $rs_result = mysqli_query($conn, $query);
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <!-- content -->
    <div class="content px-4">
        <div class="row">
            <!-- Search -->
            <div class="col-lg-3 py-2 p-0 text-start">
                <form class="form-inline" id="searchForm" action="display_program.php" method="GET">
                    <div class="form-group rounded border border-primary">
                        <input class="form-control mr-sm-2 border-0 outline-0" type="text" name="search_id"
                            placeholder="Search by ID..." aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0 border-0 rounded-0" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-3 py-2 p-0 text-start">
                <a href="display_program.php" class="btn btn-primary "><i class="fa-solid fa-arrows-rotate"></i>
                    Refresh</a>
            </div>
            <div class="col-6 py-2 p-0 text-end">
                <a href="form_program.php" class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                    Add New</a>
            </div>
        </div>
        <div class="row d-flex align-items-center p-3 bg-primary text-white">
            <div class="col-lg-1 fs-5 font-weight-bold">ID</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Year</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Semester</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Shift</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Degree</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Major</div>
            <div class="col-lg-1 fs-5 font-weight-bold">Action</div>
        </div>
        <?php
            $bg_color_class = 'DFDFDF';
            if (mysqli_num_rows($rs_result) > 0) {
                while ($row = mysqli_fetch_array($rs_result)) {
                    $bg_color_class = ($bg_color_class == 'DFDFDF') ? 'bg-white' : 'DFDFDF';
        ?>
        <div class="row d-flex align-items-center p-2 border DFDFDF <?php echo $bg_color_class; ?>">
            <div class="col-lg-1 font-weight-bold text-truncate"><?php echo $row['programid'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['yearen'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['semesteren'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['shiften'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['degreenameen'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['majoren'] ?></div>

            <div class="col-lg-1 fs-5">
                <!-- See More dropdown -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="seeMoreDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="seeMoreDropdown">
                        <li><a class="dropdown-item"
                                href="edit_program.php?programid=<?php echo $row['programid'] ?>"><i
                                    class="fa-solid fa-pencil fs-sm-7"></i>
                                Edit</a></li>
                        <li><a class="dropdown-item"
                                href="view_program.php?programid=<?php echo $row['programid'] ?>"><i
                                    class="fa-solid fa-magnifying-glass fs-sm-7"></i>
                                View Form</a>
                        </li>
                        <li><a class="dropdown-item text-danger"
                                href="delete_program.php?programid=<?php echo $row['programid'] ?>"><i
                                    class="fa-solid fa-trash-can fs-sm-7"></i>
                                Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
                }
            } else {
        ?>
        <div class="row d-flex align-items-center p-2 border bg-warning">
            <div class='col-lg-12 text-white'>
                No results found.
            </div>
        </div>
        <?php
            }

            // Pagination links
            $query = "SELECT COUNT(*) AS count FROM tblprogram";
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