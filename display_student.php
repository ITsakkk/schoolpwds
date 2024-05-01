<?php
include("connection.php");

// Pagination variables
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search_id = isset($_GET['search_id']) ? $_GET['search_id'] : '';

// Modify the SQL query to select student information
$query = "SELECT 
    s.studentid,
    s.nameinkhmer,
    s.nameinlatin,
    s.familyname,
    s.givenname,
    s.sexid,
    sx.sexen AS sex_name,
    s.idpassportno,
    s.nationalityid,
    n.nationalityen AS nationality_name,
    s.countryid,
    c.countrykh AS country_name,
    s.dob,
    s.pob,
    s.phonenumber,
    s.email,
    s.currentaddress,
    s.currentaddresspp,
    s.photo,
    s.registerdate
FROM
    tblstudentinfo s
JOIN
    tblsex sx ON s.sexid = sx.sexid
JOIN
    tblnationality n ON s.nationalityid = n.nationalityid
JOIN
    tblcountry c ON s.countryid = c.countryid
WHERE
    s.statusid = 1"; // Add condition to filter by statusid

// Add search condition
if (!empty($search_id)) {
    $query .= " AND s.studentid = $search_id";
}

// Add pagination
$query .= " LIMIT $start, $limit";

$rs_result = mysqli_query($conn, $query);
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
                <form class="form-inline" id="searchForm" action="display_student.php" method="GET">
                    <div class="form-group rounded border border-primary">
                        <input class="form-control mr-sm-2 border-0 outline-0" type="text" name="search_id"
                            placeholder="Search by ID..." aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0 border-0 rounded-0" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-3 py-2 p-0 text-start">
                <a href="display_student.php" class="btn btn-primary "><i class="fa-solid fa-arrows-rotate"></i>
                    Refresh</a>
            </div>
            <div class="col-6 py-2 p-0 text-end">
                <a href="form_student.php" class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                    Add New</a>
            </div>
        </div>

        <!-- Student Table -->
        <div class="row d-flex align-items-center p-3 bg-primary text-white">
            <!-- Table Headers -->
            <div class="col-lg-1 fs-5 font-weight-bold">ID</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Full Name</div>
            <div class="col-lg-1 fs-5 font-weight-bold">Sex</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Phone Number</div>
            <div class="col-lg-1 fs-5 font-weight-bold">Email</div>
            <div class="col-lg-1 fs-5 font-weight-bold">Address</div>
            <div class="col-lg-2 fs-5 font-weight-bold">Register</div>
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
            <div class="col-lg-1 font-weight-bold text-truncate"><?php echo $row['studentid'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['nameinlatin'] ?></div>
            <div class="col-lg-1 text-truncate"><?php echo $row['sex_name'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['phonenumber'] ?></div>
            <div class="col-lg-1 text-truncate"><?php echo $row['email'] ?></div>
            <div class="col-lg-1 text-truncate"><?php echo $row['currentaddress'] ?></div>
            <div class="col-lg-2 text-truncate"><?php echo $row['registerdate'] ?></div>

            <!-- Action Buttons -->
            <div class="col-lg-2 fs-5">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="seeMoreDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="seeMoreDropdown">
                        <li><a class="dropdown-item"
                                href="edit_student.php?studentid=<?php echo $row['studentid'] ?>"><i
                                    class="fa-solid fa-pencil fs-sm-7"></i> Edit</a></li>
                        <li><a class="dropdown-item" href="tap.php?studentid=<?php echo $row['studentid'] ?>"><i
                                    class="fa-solid fa-magnifying-glass fs-sm-7"></i> View Form</a></li>
                        <li><a class="dropdown-item text-danger"
                                href="delete_student.php?studentid=<?php echo $row['studentid'] ?>"><i
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
        $query = "SELECT COUNT(*) AS count FROM tblstudentinfo WHERE statusid = 1";
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