<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include("script.php");
        include("connection.php");
        $subject_id = $_GET['subjectid'];
        
        $query = "SELECT 
        tblsubject.subjectid,
        tblsubject.subjectkh,
        tblsubject.subjecten,
        tblsubject.creditnumber,
        tblsubject.hours,
        tblfaculty.facultyen,
        tblmajor.majoren,
        tblyear.yearen,
        tblsemester.semesterkh,
        tblfaculty.facultykh,
        tblmajor.majorkh,
        tblyear.yearkh,
        tblsemester.semesteren,
        GROUP_CONCAT(tblresource.ResourceName) AS ResourceNames,
        GROUP_CONCAT(tblresource.ResourceURL) AS ResourceURLs
    FROM 
        tblsubject
    INNER JOIN 
        tblfaculty ON tblsubject.facultyid = tblfaculty.facultyid
    INNER JOIN 
        tblmajor ON tblsubject.majorid = tblmajor.majorid
    INNER JOIN 
        tblyear ON tblsubject.yearid = tblyear.yearid
    INNER JOIN 
        tblsemester ON tblsubject.semesterid = tblsemester.semesterid
    LEFT JOIN
        tblresource ON tblsubject.subjectid = tblresource.SubjectID";

// Query to retrieve subject details based on the subject ID
$query .= " WHERE tblsubject.subjectid = $subject_id";
$result = mysqli_query($conn, $query);

// Fetch subject details
$row = mysqli_fetch_assoc($result);
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
                View Subject
            </div>
        </div>
        <div class="row row py-4 bg-light">
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Subject ID</label>
            </div>
            <div class="col-9">
                <p class="fs-3">: <?php
                    echo $row['subjectid'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Subject In Khmer</label>
            </div>
            <div class="col-9">
                <p class="fs-3">: <?php
                    echo $row['subjectkh'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Subejct In English</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['subjecten'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Create</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['creditnumber'];
                ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Hour</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['hours'];
                ?></p>
            </div>
            <div class="col-3 ">
                <label for="" class="form-label fs-2 ">Year Khmer</label>

            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['yearkh'];
                ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Year English</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['yearen'];
                ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Semester Khmer</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['semesterkh'];
                ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Semester English</label>
            </div>
            <div class="col-lg-9">
                <p class="fs-3">: <?php
                    echo $row['semesteren'];
                    ?></p>
            </div>
            <div class="col-3">
                <label for="" class="form-label fs-2 ">Resource</label>
            </div>
            <div class="col-lg-9">
                <?php 
                    if (!empty($row['ResourceNames'])) {
                        // Split the resource names and URLs into arrays
                        $resourceNames = explode(',', $row['ResourceNames']);
                        $resourceURLs = explode(',', $row['ResourceURLs']);
            
                        // Output the dropdown icon
                        echo '<div class="dropdown fs-3">';
                        echo ': <button class="btn dropdown-toggle fs-3 pl-0" type="button" id="resourceDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo 'Resources';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" aria-labelledby="resourceDropdown">';
                        
                        // Iterate over each resource and output the link
                        for ($i = 0; $i < count($resourceNames); $i++) {
                            echo '<li><a class="dropdown-item" href="img/' . $resourceURLs[$i] . '"> <i class="fa-solid fa-download fs-sm-7"></i> ' . $resourceNames[$i] . '</a></li>';
                        }
                        
                        echo '</ul>';
                        echo '</div>';
                    } else {
                        echo '<p class="fs-3">: No resource available</p>';
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 p-0 py-2">
                <a class="btn bg-primary text-white m-0" href="display_subject.php">
                    Cancel</a>
                <a class="btn bg-primary text-white m-0"
                    href="edit_subject.php?subjectid=<?php echo $row['subjectid'] ?>">
                    Edit</a>
            </div>
        </div>


    </div>
    <!-- end of content -->

</body>

</html>