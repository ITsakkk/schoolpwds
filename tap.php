<?php
// Include your database connection file
include("connection.php");

// Fetch student information from tblstudentinfo
// Fetch student information from tblstudentinfo with joins
$query_student_info = "
    SELECT 
        si.*, 
        s.sexen, 
        n.nationalityen, 
        c.countryen
    FROM 
        tblstudentinfo si
    LEFT JOIN 
        tblsex s ON si.sexid = s.sexid
    LEFT JOIN 
        tblnationality n ON si.nationalityid = n.nationalityid
    LEFT JOIN 
        tblcountry c ON si.countryid = c.countryid
    WHERE 
        si.studentid = {$_GET['studentid']}
        AND statusid = 1;
";

$result_student_info = mysqli_query($conn, $query_student_info);
$student_info = mysqli_fetch_assoc($result_student_info);


// Fetch family background information from tblfamilybackground
$query_family_background = "
    SELECT
        fb.familybackgroundid,
        fb.fathername,
        fb.fatherage,
        n1.nationalityen AS fathernationality,
        c1.countryen AS fathercountry,
        o1.occupationname AS fatheroccupation,
        fb.mothername,
        fb.motherage,
        n2.nationalityen AS mothernationality,
        c2.countryen AS mothercountry,
        o2.occupationname AS motheroccupation,
        fb.familycurrentaddress,
        fb.spousename,
        fb.spouseage,
        fb.guardianphonenumber,
        st.nameinlatin AS studentname
    FROM
        tblfamilybackground fb
    LEFT JOIN
        tblnationality n1 ON fb.fathernationalityid = n1.nationalityid
    LEFT JOIN
        tblcountry c1 ON fb.fathercountryid = c1.countryid
    LEFT JOIN
        tbloccupation o1 ON fb.fatheroccupationid = o1.occupationid
    LEFT JOIN
        tblnationality n2 ON fb.mothernationalityid = n2.nationalityid
    LEFT JOIN
        tblcountry c2 ON fb.mothercountryid = c2.countryid
    LEFT JOIN
        tbloccupation o2 ON fb.motheroccupationid = o2.occupationid
    LEFT JOIN
        tblstudentinfo st ON fb.studentid = st.studentid
    WHERE 
        fb.studentid = {$_GET['studentid']}
";
$result_family_background = mysqli_query($conn, $query_family_background);
$family_background = mysqli_fetch_assoc($result_family_background);

// Fetch educational background information from tbleducationalbackground
$query_educational_background = "SELECT
 eb. *,
 st.schooltypeen, 
 st.schooltypekh
 FROM tbleducationalbackground eb
 LEFT JOIN tblschooltype st on eb.schooltypeid = st.schooltypeid
 WHERE studentid = {$_GET['studentid']}
 ";
$result_educational_background = mysqli_query($conn, $query_educational_background);
$educational_background = mysqli_fetch_assoc($result_educational_background);

$query_student_status = "
    SELECT
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
        p.startdate,
        p.enddate,
        p.dateissue,
        p.programid
    FROM
        tblstudentstatus ss
    JOIN
        tblprogram p ON ss.programid = p.programid
    LEFT JOIN
        tblyear yr ON p.yearid = yr.yearid
    LEFT JOIN
        tblsemester sem ON p.semesterid = sem.semesterid
    LEFT JOIN
        tblshift sh ON p.shiftid = sh.shiftid
    LEFT JOIN
        tbldegree deg ON p.degreeid = deg.degreeid
    LEFT JOIN
        tblacademicyear acy ON p.academicyearid = acy.academicyearid
    LEFT JOIN
        tblmajor maj ON p.majorid = maj.majorid
    LEFT JOIN
        tblbatch bat ON p.batchid = bat.batchid
    WHERE
        ss.studentid = ?
    ORDER BY
        ss.studentstatusid DESC
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $query_student_status);
mysqli_stmt_bind_param($stmt, "i", $_GET['studentid']);
mysqli_stmt_execute($stmt);
$result_student_status = mysqli_stmt_get_result($stmt);
$student_status = mysqli_fetch_assoc($result_student_status);

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
        <!-- <div class="row">
            <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                Student Information
            </div>
        </div> -->
        <ul class="nav nav-tabs pl-1" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link p-4 active" id="student-info-tab" data-toggle="tab" href="#student-info" role="tab"
                    aria-controls="student-info" aria-selected="true">Student Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-4" id="family-background-tab" data-toggle="tab" href="#family-background"
                    role="tab" aria-controls="family-background" aria-selected="false">Family Background</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-4" id="education-background-tab" data-toggle="tab" href="#education-background"
                    role="tab" aria-controls="education-background" aria-selected="false">Education Background</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-4" id="student-status-tab" data-toggle="tab" href="#student-status" role="tab"
                    aria-controls="student-status-tab" aria-selected="false">Student Status</a>
            </li>
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
                                        <p class="fs-5 text-dark"><?php echo $student_info['nameinlatin']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Birthday</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['dob']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Address</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['currentaddress']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Phone Number</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['phonenumber']; ?></p>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Email</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['email']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4  text-end">
                                <img src="img/<?php echo $student_info['photo']; ?>"
                                    class="img-fluid custom-circular-image" alt="Circular Image">
                            </div>
                            <div class="col-12 mb-4">
                                <a class="btn btn-outline-primary"
                                    href="edit_student.php?studentid=<?php echo $student_info['studentid'] ?>"><i
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
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Student ID</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['studentid']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Name in Khmer</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['nameinkhmer']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Name in Latin</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['nameinlatin']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Family Name</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['familyname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Given Name</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['givenname']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Sex</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['sexen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">ID Passport</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['idpassportno']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Nationality</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['nationalityen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Country</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['countryen']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Place of Birth</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['pob']; ?></p>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label fs-5 text-dark fw-bold">Register Date</label>
                                        <p class="fs-5 text-dark"><?php echo $student_info['registerdate']; ?></p>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <a class="btn btn-outline-primary"
                                            href="edit_student.php?studentid=<?php echo $student_info['studentid'] ?>"><i
                                                class="fa-solid fa-pencil fs-sm-7"></i>
                                            Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                                <i class="fas fa-users"></i>
                                Family Background
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Father's Name</label>
                                    <p class="fs-5"><?php echo $family_background['fathername']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Father's Age</label>
                                    <p class="fs-5"><?php echo $family_background['fatherage']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Father's Nationality</label>
                                    <p class="fs-5"><?php echo $family_background['fathernationality']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Father's Country</label>
                                    <p class="fs-5"><?php echo $family_background['fathercountry']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Father's Occupation</label>
                                    <p class="fs-5"><?php echo $family_background['fatheroccupation']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Name</label>
                                    <p class="fs-5"><?php echo $family_background['mothername']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Age</label>
                                    <p class="fs-5"><?php echo $family_background['motherage']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Nationality</label>
                                    <p class="fs-5"><?php echo $family_background['mothernationality']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Country</label>
                                    <p class="fs-5"><?php echo $family_background['mothercountry']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Occupation</label>
                                    <p class="fs-5"><?php echo $family_background['motheroccupation']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Family's Address</label>
                                    <p class="fs-5"><?php echo $family_background['familycurrentaddress']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Spouse's Name</label>
                                    <p class="fs-5"><?php echo $family_background['spousename']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Spouse's Age</label>
                                    <p class="fs-5"><?php echo $family_background['spouseage']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Guardian's Phone
                                        Number</label>
                                    <p class="fs-5"><?php echo $family_background['guardianphonenumber']; ?></p>
                                </div>
                                <div class="col-12 mb-4">
                                    <a class="btn btn-outline-primary"
                                        href="edit_familybackground.php?studentid=<?php echo $student_info['studentid'] ?>"><i
                                            class="fa-solid fa-pencil fs-sm-7"></i>
                                        Edit</a>
                                </div>
                            </div>
                            <div class="col-12 bg-primary text-white p-1 mb-4  pl-3 fs-4 mt-2">
                                <i class="fa-solid fa-graduation-cap"></i>
                                Education Background
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">School Name</label>
                                    <p class="fs-5"><?php echo $educational_background['nameschool']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">School Type KH</label>
                                    <p class="fs-5"><?php echo $educational_background['schooltypekh']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">School Type EN</label>
                                    <p class="fs-5"><?php echo $educational_background['schooltypeen']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                                    <p class="fs-5"><?php echo $educational_background['academicyear']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Province</label>
                                    <p class="fs-5"><?php echo $educational_background['province']; ?></p>
                                </div>
                                <div class="col-12 mb-4">
                                    <a class="btn btn-outline-primary"
                                        href="edit_edubackground.php?studentid=<?php echo $student_info['studentid'] ?>"><i
                                            class="fa-solid fa-pencil fs-sm-7"></i>
                                        Edit</a>
                                </div>
                            </div>
                            <div class="col-12 bg-primary text-white p-1 mb-4  pl-3 fs-4 mt-2">
                                <i class="fas fa-check-circle"></i>
                                Student Status
                            </div>
                            <div class="row fs-5">
                                <div class="col-4">
                                    <span for="" class="form-label fs-5 text-dark fw-bold">Program
                                    </span>
                                    <p class="fs-5 text-dark"><?php echo $student_status['programid']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Major</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['majoren']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Year</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['yearen']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Semester</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['semesteren']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Shift</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['shiften']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Degree</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['degreenameen']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['academicyear']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Batch</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['batchen']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Assigned</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['assigned']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Note</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['note']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Assign Date</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['assigndate']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Start Date</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['startdate']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">End Data</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['enddate']; ?></p>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label fs-5 text-dark fw-bold">Date Issue</label>
                                    <p class="fs-5 text-dark"><?php echo $student_status['dateissue']; ?></p>
                                </div>
                                <div class="col-12 mb-4">
                                    <a class="btn btn-outline-primary"
                                        href="edit_studentstatus.php?studentstatusid=<?php echo $student_status['studentstatusid'] ?>"><i
                                            class="fa-solid fa-pencil fs-sm-7"></i>
                                        Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="family-background" role="tabpanel" aria-labelledby="family-background-tab">
                <div class="row">
                    <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                        <i class="fas fa-users"></i>
                        Family Background
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Father's Name</label>
                        <p class="fs-5"><?php echo $family_background['fathername']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Father's Age</label>
                        <p class="fs-5"><?php echo $family_background['fatherage']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Father's Nationality</label>
                        <p class="fs-5"><?php echo $family_background['fathernationality']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Father's Country</label>
                        <p class="fs-5"><?php echo $family_background['fathercountry']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Father's Occupation</label>
                        <p class="fs-5"><?php echo $family_background['fatheroccupation']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Name</label>
                        <p class="fs-5"><?php echo $family_background['mothername']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Age</label>
                        <p class="fs-5"><?php echo $family_background['motherage']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Nationality</label>
                        <p class="fs-5"><?php echo $family_background['mothernationality']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Country</label>
                        <p class="fs-5"><?php echo $family_background['mothercountry']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Mother's Occupation</label>
                        <p class="fs-5"><?php echo $family_background['motheroccupation']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Family's Address</label>
                        <p class="fs-5"><?php echo $family_background['familycurrentaddress']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Spouse's Name</label>
                        <p class="fs-5"><?php echo $family_background['spousename']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Spouse's Age</label>
                        <p class="fs-5"><?php echo $family_background['spouseage']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Guardian's Phone
                            Number</label>
                        <p class="fs-5"><?php echo $family_background['guardianphonenumber']; ?></p>
                    </div>
                    <div class="col-12 mb-4">
                        <a class="btn btn-outline-primary"
                            href="edit_familybackground.php?studentid=<?php echo $student_info['studentid'] ?>"><i
                                class="fa-solid fa-pencil fs-sm-7"></i>
                            Edit</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="education-background" role="tabpanel"
                aria-labelledby="education-background-tab">
                <div class="row">
                    <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Education Background
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="" class="form-label fs-5 text-dark fw-bold">School Name</label>
                            <p class="fs-5"><?php echo $educational_background['nameschool']; ?></p>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label fs-5 text-dark fw-bold">School Type KH</label>
                            <p class="fs-5"><?php echo $educational_background['schooltypekh']; ?></p>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label fs-5 text-dark fw-bold">School Type EN</label>
                            <p class="fs-5"><?php echo $educational_background['schooltypeen']; ?></p>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                            <p class="fs-5"><?php echo $educational_background['academicyear']; ?></p>
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label fs-5 text-dark fw-bold">Province</label>
                            <p class="fs-5"><?php echo $educational_background['province']; ?></p>
                        </div>
                        <div class="col-12 mb-4">
                            <a class="btn btn-outline-primary"
                                href="edit_edubackground.php?studentid=<?php echo $student_info['studentid'] ?>"><i
                                    class="fa-solid fa-pencil fs-sm-7"></i>
                                Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="student-status" role="tabpanel" aria-labelledby="student-status-tab">
                <?php
                   $query_student_status = "
                   SELECT
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
                       p.startdate,
                       p.enddate,
                       p.dateissue,
                       p.programid
                   FROM
                       tblstudentstatus ss
                   JOIN
                       tblprogram p ON ss.programid = p.programid
                   LEFT JOIN
                       tblyear yr ON p.yearid = yr.yearid
                   LEFT JOIN
                       tblsemester sem ON p.semesterid = sem.semesterid
                   LEFT JOIN
                       tblshift sh ON p.shiftid = sh.shiftid
                   LEFT JOIN
                       tbldegree deg ON p.degreeid = deg.degreeid
                   LEFT JOIN
                       tblacademicyear acy ON p.academicyearid = acy.academicyearid
                   LEFT JOIN
                       tblmajor maj ON p.majorid = maj.majorid
                   LEFT JOIN
                       tblbatch bat ON p.batchid = bat.batchid
                   WHERE
                       ss.studentid = {$_GET['studentid']}
                   ORDER BY
                       ss.studentstatusid DESC";
           
               // Execute the query
               $result_student_status = mysqli_query($conn, $query_student_status);
               ?>
                <div class="row">
                    <div class="col-12 py-2 p-0">
                        <a href="form_studentstatus.php?studentid=<?php echo $student_info['studentid'] ?>"
                            class="btn btn-primary "><i class="fa-solid fa-circle-plus"></i>
                            Add Status</a>
                    </div>
                </div>
                <?php
                    // Check if the query was successful
                    if($result_student_status) {
                    // Output the result (you can customize this part based on your HTML structure)
                    while ($status = mysqli_fetch_assoc($result_student_status)) {
                    ?>
                <div class="row">
                    <div class="col-12 bg-primary text-white p-1 mb-3 pl-3 fs-4 ">
                        <i class="fa-solid fa-gear"></i>
                        Program
                        <?php echo $status['programid']; ?></span>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Major</label>
                        <p class="fs-5 text-dark"><?php echo $status['majoren']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Year</label>
                        <p class="fs-5 text-dark"><?php echo $status['yearen']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Semester</label>
                        <p class="fs-5 text-dark"><?php echo $status['semesteren']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Shift</label>
                        <p class="fs-5 text-dark"><?php echo $status['shiften']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Degree</label>
                        <p class="fs-5 text-dark"><?php echo $status['degreenameen']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Academic Year</label>
                        <p class="fs-5 text-dark"><?php echo $status['academicyear']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Batch</label>
                        <p class="fs-5 text-dark"><?php echo $status['batchen']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Assigned</label>
                        <p class="fs-5 text-dark"><?php echo $status['assigned']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Note</label>
                        <p class="fs-5 text-dark"><?php echo $status['note']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Assign Date</label>
                        <p class="fs-5 text-dark"><?php echo $status['assigndate']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Start Date</label>
                        <p class="fs-5 text-dark"><?php echo $status['startdate']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">End Data</label>
                        <p class="fs-5 text-dark"><?php echo $status['enddate']; ?></p>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fs-5 text-dark fw-bold">Date Issue</label>
                        <p class="fs-5 text-dark"><?php echo $status['dateissue']; ?></p>
                    </div>
                    <div class="col-12 mb-4">
                        <a class="btn btn-outline-primary"
                            href="edit_studentstatus.php?studentstatusid=<?php echo $status['studentstatusid'] ?>"><i
                                class="fa-solid fa-pencil fs-sm-7"></i>
                            Edit</a>
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