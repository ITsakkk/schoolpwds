<?php
include("connection.php");

// Check if a student ID is provided in the URL parameter
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['studentid'])) {
    $studentid = $_GET['studentid'];

    // Retrieve student information from the database
    $query = "SELECT * FROM tblstudentinfo WHERE studentid = $studentid";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nameinkhmer = $row['nameinkhmer'];
        $nameinlatin = $row['nameinlatin'];
        $familyname = $row['familyname'];
        $givenname = $row['givenname'];
        $sexid = $row['sexid'];
        $statusid = $row['statusid'];
        $idpassportno = $row['idpassportno'];
        $nationalityid = $row['nationalityid'];
        $countryid = $row['countryid'];
        $dob = $row['dob'];
        $pob = $row['pob'];
        $phonenumber = $row['phonenumber'];
        $email = $row['email'];
        $currentaddress = $row['currentaddress'];
        $currentaddresspp = $row['currentaddresspp'];
        $photo = $row['photo'];
        $registerdate = $row['registerdate'];
    } else {
        echo "Student not found.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update student information
    $studentid = $_POST['studentid'];
    $nameinkhmer = $_POST['nameinkhmer'];
    $nameinlatin = $_POST['nameinlatin'];
    $familyname = $_POST['familyname'];
    $givenname = $_POST['givenname'];
    $sexid = $_POST['sexid'];
    $statusid = $_POST['statusid'];
    $idpassportno = $_POST['idpassportno'];
    $nationalityid = $_POST['nationalityid'];
    $countryid = $_POST['countryid'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $currentaddress = $_POST['currentaddress'];
    $currentaddresspp = $_POST['currentaddresspp'];
    $registerdate = $_POST['registerdate'];
   
    
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
        $query_old_url = "SELECT photo FROM tblstudentinfo WHERE studentid = ?";
        $stmt_old_url = mysqli_prepare($conn, $query_old_url);
        mysqli_stmt_bind_param($stmt_old_url, "i", $studentid);
        mysqli_stmt_execute($stmt_old_url);
        $result_old_url = mysqli_stmt_get_result($stmt_old_url);
        $row_old_url = mysqli_fetch_assoc($result_old_url);
        $resourceURL = $row_old_url['photo'];
    }
    
    // Execute the update query
    $sql = "UPDATE tblstudentinfo SET nameinkhmer=?, nameinlatin=?, familyname=?, givenname=?, sexid=?, idpassportno=?, nationalityid=?, countryid=?, dob=?, pob=?, phonenumber=?, email=?, currentaddress=?, currentaddresspp=?, photo=?, registerdate=?, statusid=? WHERE studentid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssssssssssi", $nameinkhmer, $nameinlatin, $familyname, $givenname, $sexid, $idpassportno, $nationalityid, $countryid, $dob, $pob, $phonenumber, $email, $currentaddress, $currentaddresspp, $resourceURL, $registerdate,$statusid, $studentid);
    mysqli_stmt_execute($stmt);

    if (!$stmt) {
        $ErrorMessage = "Invalid Query: " . mysqli_error($conn);
    } else {
        // Check statusid and redirect accordingly
        if ($statusid == 1) {
            header("Location: tap.php?studentid=$studentid");
        } elseif ($statusid == 2) {
            header("Location: display_student.php");
        } else {
            // Handle other cases if needed
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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
                    Edit Student
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">ID</label>
                    <input type="text" value="<?php echo $studentid ?>" name="studentid" id="" class="form-control"
                        readonly>
                </div>
                <div class="col-lg-6">
                    <label for="nameinkhmer" class="form-label">Name in khmer</label>
                    <input type="text" name="nameinkhmer" value="<?php echo $nameinkhmer ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="nameinlatin" class="form-label">Name in Latin</label>
                    <input type="text" name="nameinlatin" value="<?php echo $nameinlatin ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="familyname" class="form-label">Family Name</label>
                    <input type="text" name="familyname" value="<?php echo $familyname ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="givenname" class="form-label">Given Name</label>
                    <input type="text" name="givenname" value="<?php echo $givenname ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="sexid" class="form-label">Sex</label>
                    <select name="sexid" id="sexid" class="form-control">
                        <option value="1" <?php if($sexid == 1) echo 'selected'; ?>>Male</option>
                        <option value="2" <?php if($sexid == 2) echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="idpassportno" class="form-label">ID Passport Number</label>
                    <input type="text" name="idpassportno" value="<?php echo $idpassportno ?>" id=""
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
                <!-- End of select dropdowns -->
                <div class="col-lg-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" value="<?php echo $dob ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="pob" class="form-label">Place of Birth</label>
                    <input type="text" name="pob" value="<?php echo $pob ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="phonenumber" class="form-label">Phone Number</label>
                    <input type="text" name="phonenumber" value="<?php echo $phonenumber ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php echo $email ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="currentaddress" class="form-label">Current Address</label>
                    <input type="text" name="currentaddress" value="<?php echo $currentaddress ?>" id=""
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="currentaddresspp" class="form-label">Current Address PP</label>
                    <input type="text" name="currentaddresspp" value="<?php echo $currentaddresspp ?>" id=""
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="registerdate" class="form-label">Register Date</label>
                    <input type="date" name="registerdate" value="<?php echo $registerdate ?>" id="registerdate"
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="statusid" class="form-label">Status</label>
                    <select name="statusid" id="sexid" class="form-control">
                        <option value="1" <?php if($statusid == 1) echo 'selected'; ?>>enable</option>
                        <option value="2" <?php if($statusid == 2) echo 'selected'; ?>>disable</option>
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0"
                        href="tap.php?studentid=<?php echo $studentid ?>">Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>