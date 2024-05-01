<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Family Background</title>
    <?php
        include("script.php");
        include("connection.php");

        // Check if familybackgroundid is provided
        if(isset($_GET['studentid'])) {
            // Retrieve family background data based on familybackgroundid
            $studentid = $_GET['studentid'];
            $sql = "SELECT * FROM tblfamilybackground WHERE studentid = '$studentid'";
            $result = mysqli_query($conn, $sql);

            // Check if data exists
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "No data found for the specified family background ID.";
                exit;
            }
        } else {
         
            // Extract data from the form submission
            $familybackgroundid = $_POST['familybackgroundid'];
            $fathername = $_POST['fathername'];
            $fatherage = $_POST['fatherage'];
            $fatheroccupationid = $_POST['fatheroccupationid'];
            $fathernationalityid = $_POST['fathernationalityid'];
            $fathercountryid = $_POST['fathercountryid'];
            $mothername = $_POST['mothername'];
            $motherage = $_POST['motherage'];
            $motheroccupationid = $_POST['motheroccupationid'];
            $mothernationalityid = $_POST['mothernationalityid'];
            $mothercountryid = $_POST['mothercountryid'];
            $familycurrentaddress = $_POST['familycurrentaddress'];
            $spousename = $_POST['spousename'];
            $spouseage = $_POST['spouseage'];
            $guardianphonenumber = $_POST['guardianphonenumber'];
            $studentid = $_POST['studentid'];

            // Perform the update operation
            $sql_update = "UPDATE tblfamilybackground SET fathername='$fathername', fatherage='$fatherage', fatheroccupationid='$fatheroccupationid', fathernationalityid='$fathernationalityid', fathercountryid='$fathercountryid', mothername='$mothername', motherage='$motherage', motheroccupationid='$motheroccupationid', mothernationalityid='$mothernationalityid', mothercountryid='$mothercountryid', familycurrentaddress='$familycurrentaddress', spousename='$spousename', spouseage='$spouseage', guardianphonenumber='$guardianphonenumber' WHERE studentid = '$studentid'";

            // Execute the update query
            if (mysqli_query($conn, $sql_update)) {
                header("Location: tap.php?studentid=$studentid");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Family Background
                </div>
            </div>
            <div class="row py-4 bg-light">
                <!-- Father's fields -->
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student ID</label>
                    <input type="text" id="studentid" name="studentid" class="form-control"
                        value="<?php echo $row['studentid']; ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="fathername" class="form-label">Father's Name</label>
                    <input type="text" id="fathername" name="fathername" class="form-control"
                        value="<?php echo $row['fathername']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="fatherage" class="form-label">Father's Age</label>
                    <input type="text" id="fatherage" name="fatherage" class="form-control"
                        value="<?php echo $row['fatherage']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="fatheroccupationid" class="form-label">Father's Occupation</label>
                    <select id="fatheroccupationid" name="fatheroccupationid" class="form-select" required>
                        <option value="">Select Father's Occupation</option>
                        <?php
                            $sql_father_occupation = "SELECT occupationid, occupationname FROM tbloccupation";
                            $result_father_occupation = mysqli_query($conn, $sql_father_occupation);
                            while ($row_occupation = mysqli_fetch_assoc($result_father_occupation)) {
                                $selected = ($row_occupation['occupationid'] == $row['fatheroccupationid']) ? "selected" : "";
                                echo "<option value='{$row_occupation['occupationid']}' $selected>{$row_occupation['occupationname']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="fathernationalityid" class="form-label">Father's Nationality</label>
                    <select id="fathernationalityid" name="fathernationalityid" class="form-select" required>
                        <option value="">Select Father's Nationality</option>
                        <?php
                            $sql_father_nationality = "SELECT nationalityid, nationalityen FROM tblnationality";
                            $result_father_nationality = mysqli_query($conn, $sql_father_nationality);
                            while ($row_nationality = mysqli_fetch_assoc($result_father_nationality)) {
                                $selected = ($row_nationality['nationalityid'] == $row['fathernationalityid']) ? "selected" : "";
                                echo "<option value='{$row_nationality['nationalityid']}' $selected>{$row_nationality['nationalityen']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="fathercountryid" class="form-label">Father's Country</label>
                    <select id="fathercountryid" name="fathercountryid" class="form-select" required>
                        <option value="">Select Father's Country</option>
                        <?php
                            $sql_father_country = "SELECT countryid, countryen FROM tblcountry";
                            $result_father_country = mysqli_query($conn, $sql_father_country);
                            while ($row_country = mysqli_fetch_assoc($result_father_country)) {
                                $selected = ($row_country['countryid'] == $row['fathercountryid']) ? "selected" : "";
                                echo "<option value='{$row_country['countryid']}' $selected>{$row_country['countryen']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <!-- Mother's fields -->
                <div class="col-lg-6">
                    <label for="mothername" class="form-label">Mother's Name</label>
                    <input type="text" id="mothername" name="mothername" class="form-control"
                        value="<?php echo $row['mothername']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="motherage" class="form-label">Mother's Age</label>
                    <input type="text" id="motherage" name="motherage" class="form-control"
                        value="<?php echo $row['motherage']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="motheroccupationid" class="form-label">Mother's Occupation</label>
                    <select id="motheroccupationid" name="motheroccupationid" class="form-select" required>
                        <option value="">Select Mother's Occupation</option>
                        <?php
                            $sql_mother_occupation = "SELECT occupationid, occupationname FROM tbloccupation";
                            $result_mother_occupation = mysqli_query($conn, $sql_mother_occupation);
                            while ($row_occupation = mysqli_fetch_assoc($result_mother_occupation)) {
                                $selected = ($row_occupation['occupationid'] == $row['motheroccupationid']) ? "selected" : "";
                                echo "<option value='{$row_occupation['occupationid']}' $selected>{$row_occupation['occupationname']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="mothernationalityid" class="form-label">Mother's Nationality</label>
                    <select id="mothernationalityid" name="mothernationalityid" class="form-select" required>
                        <option value="">Select Mother's Nationality</option>
                        <?php
                            $sql_mother_nationality = "SELECT nationalityid, nationalityen FROM tblnationality";
                            $result_mother_nationality = mysqli_query($conn, $sql_mother_nationality);
                            while ($row_nationality = mysqli_fetch_assoc($result_mother_nationality)) {
                                $selected = ($row_nationality['nationalityid'] == $row['mothernationalityid']) ? "selected" : "";
                                echo "<option value='{$row_nationality['nationalityid']}' $selected>{$row_nationality['nationalityen']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="mothercountryid" class="form-label">Mother's Country</label>
                    <select id="mothercountryid" name="mothercountryid" class="form-select" required>
                        <option value="">Select Mother's Country</option>
                        <?php
                            $sql_mother_country = "SELECT countryid, countryen FROM tblcountry";
                            $result_mother_country = mysqli_query($conn, $sql_mother_country);
                            while ($row_country = mysqli_fetch_assoc($result_mother_country)) {
                                $selected = ($row_country['countryid'] == $row['mothercountryid']) ? "selected" : "";
                                echo "<option value='{$row_country['countryid']}' $selected>{$row_country['countryen']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <!-- Remaining fields -->
                <div class="col-lg-6">
                    <label for="familycurrentaddress" class="form-label">Family's Current Address</label>
                    <input type="text" id="familycurrentaddress" name="familycurrentaddress" class="form-control"
                        value="<?php echo $row['familycurrentaddress']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="spousename" class="form-label">Spouse's Name</label>
                    <input type="text" id="spousename" name="spousename" class="form-control"
                        value="<?php echo $row['spousename']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="spouseage" class="form-label">Spouse's Age</label>
                    <input type="text" id="spouseage" name="spouseage" class="form-control"
                        value="<?php echo $row['spouseage']; ?>">
                </div>
                <div class="col-lg-6">
                    <label for="guardianphonenumber" class="form-label">Guardian's Phone Number</label>
                    <input type="tel" id="guardianphonenumber" name="guardianphonenumber" class="form-control"
                        value="<?php echo $row['guardianphonenumber']; ?>">
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0"
                        href="tap.php?studentid=<?php echo $studentid ?>">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>