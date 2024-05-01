<?php
include("connection.php");

// Check if a lecturer ID is provided in the URL parameter
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['lecturerid'])) {
    $lecturerid = $_GET['lecturerid'];

    // Retrieve lecturer information from the database
    $query = "SELECT * FROM tbllecturer WHERE lecturerid = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $lecturerid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Assign values to variables
        $nameinkh = $row['nameinkh'];
        $nameinlatin = $row['nameinlatin'];
        $familyname = $row['familyname'];
        $givenname = $row['givenname'];
        $sexid = $row['sexid'];
        $passportid = $row['passportid'];
        $nationalityid = $row['nationalityid'];
        $countryid = $row['countryid'];
        $professionalexperience = $row['professionalexperience'];
        $degreeid = $row['degreeid'];
        $departmentid = $row['departmentid'];
        $email = $row['email'];
        $phone = $row['phone'];
        $dob = $row['dob'];
        $publications = $row['publications'];
        $pob = $row['pob'];
        $address = $row['address'];
        $photo = $row['photo'];
        $statusid = $row['statusid'];
    } else {
        echo "Lecturer not found.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update lecturer information
    $lecturerid = $_POST['lecturerid'];
    $nameinkh = $_POST['nameinkh'];
    $nameinlatin = $_POST['nameinlatin'];
    $familyname = $_POST['familyname'];
    $givenname = $_POST['givenname'];
    $sexid = $_POST['sexid'];
    $passportid = $_POST['passportid'];
    $nationalityid = $_POST['nationalityid'];
    $countryid = $_POST['countryid'];
    $professionalexperience = $_POST['professionalexperience'];
    $degreeid = $_POST['degreeid'];
    $departmentid = $_POST['departmentid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $publications = $_POST['publications'];
    $pob = $_POST['pob'];
    $address = $_POST['address'];
    $statusid = $_POST['statusid'];

    $resourceURL = ''; // Initialize resourceURL

    if (!empty($_FILES["photo"]["name"])) {
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = "img/" . $fileName;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            $resourceURL = $fileName;
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // If no new file is selected, retain the old file data
        $query_old_url = "SELECT photo FROM tbllecturer WHERE lecturerid = ?";
        $stmt_old_url = mysqli_prepare($conn, $query_old_url);
        mysqli_stmt_bind_param($stmt_old_url, "i", $lecturerid);
        mysqli_stmt_execute($stmt_old_url);
        $result_old_url = mysqli_stmt_get_result($stmt_old_url);
        $row_old_url = mysqli_fetch_assoc($result_old_url);
        $resourceURL = $row_old_url['photo'];
    }

    // Execute the update query
    $query = "UPDATE tbllecturer SET nameinkh='$nameinkh', nameinlatin='$nameinlatin', familyname='$familyname', givenname='$givenname', sexid='$sexid', passportid='$passportid', nationalityid='$nationalityid', countryid='$countryid', professionalexperience='$professionalexperience', degreeid='$degreeid', departmentid='$departmentid', email='$email', phone='$phone', dob='$dob', publications='$publications', pob='$pob', address='$address', photo='$resourceURL', statusid='$statusid' WHERE lecturerid = $lecturerid";
    if (mysqli_query($conn, $query)) {
        if ($statusid == 1) {
            header("Location: tap_lecturer.php?lecturerid=$lecturerid");
        } elseif ($statusid == 2) {
            header("Location: display_lecturer.php");
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
    <title>Edit Lecturer</title>
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
                    Edit Lecturer
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="lecturerid" class="form-label">Lecturer ID</label>
                    <input type="text" value="<?php echo $lecturerid; ?>" name="lecturerid" id="lecturerid"
                        class="form-control" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="nameinkh" class="form-label">Name in Khmer</label>
                    <input type="text" name="nameinkh" value="<?php echo $nameinkh; ?>" id="nameinkh"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="nameinlatin" class="form-label">Name in Latin</label>
                    <input type="text" name="nameinlatin" value="<?php echo $nameinlatin; ?>" id="nameinlatin"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="familyname" class="form-label">Family Name</label>
                    <input type="text" name="familyname" value="<?php echo $familyname; ?>" id="familyname"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="givenname" class="form-label">Given Name</label>
                    <input type="text" name="givenname" value="<?php echo $givenname; ?>" id="givenname"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="sexid" class="form-label">Sex</label>
                    <select name="sexid" id="sexid" class="form-control">
                        <option value="1" <?php if($sexid == 1) echo 'selected'; ?>>Male</option>
                        <option value="2" <?php if($sexid == 2) echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="passportid" class="form-label">Passport ID</label>
                    <input type="text" name="passportid" value="<?php echo $passportid; ?>" id="passportid"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="nationalityid" class="form-label">Nationality ID</label>
                    <select name="nationalityid" id="nationalityid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
            $query_nationality = "SELECT * FROM tblnationality";
            $result_nationality = mysqli_query($conn, $query_nationality);
            while ($row_nationality = mysqli_fetch_assoc($result_nationality)) {
                $selected = ($nationalityid == $row_nationality['nationalityid']) ? 'selected' : '';
                echo "<option value='".$row_nationality['nationalityid']."' $selected>".$row_nationality['nationalityen']."</option>";
            }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="countryid" class="form-label">Country ID</label>
                    <select name="countryid" id="countryid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
            $query_country = "SELECT * FROM tblcountry";
            $result_country = mysqli_query($conn, $query_country);
            while ($row_country = mysqli_fetch_assoc($result_country)) {
                $selected = ($countryid == $row_country['countryid']) ? 'selected' : '';
                echo "<option value='".$row_country['countryid']."' $selected>".$row_country['countryen']."</option>";
            }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="professionalexperience" class="form-label">Professional Experience</label>
                    <input type="text" name="professionalexperience" value="<?php echo $professionalexperience; ?>"
                        id="professionalexperience" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="degreeid" class="form-label">Degree</label>
                    <select name="degreeid" id="degreeid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
        $query_degree = "SELECT * FROM tbldegree";
        $result_degree = mysqli_query($conn, $query_degree);
        while ($row_degree = mysqli_fetch_assoc($result_degree)) {
            $selected = ($degreeid == $row_degree['degreeid']) ? 'selected' : '';
            echo "<option value='".$row_degree['degreeid']."' $selected>".$row_degree['degreenameen']."</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="departmentid" class="form-label">Department</label>
                    <select name="departmentid" id="departmentid" class="form-control">
                        <!-- Populate options dynamically from database -->
                        <?php
        $query_department = "SELECT * FROM department";
        $result_department = mysqli_query($conn, $query_department);
        while ($row_department = mysqli_fetch_assoc($result_department)) {
            $selected = ($departmentid == $row_department['departmentid']) ? 'selected' : '';
            echo "<option value='".$row_department['departmentid']."' $selected>".$row_department['departmentname']."</option>";
        }
        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>" id="email" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" value="<?php echo $phone; ?>" id="phone" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" value="<?php echo $dob; ?>" id="dob" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="publications" class="form-label">Publications</label>
                    <textarea name="publications" id="publications"
                        class="form-control"><?php echo $publications; ?></textarea>
                </div>
                <div class="col-lg-6">
                    <label for="pob" class="form-label">Place of Birth</label>
                    <input type="text" name="pob" value="<?php echo $pob; ?>" id="pob" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" value="<?php echo $address; ?>" id="address" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control">
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
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>