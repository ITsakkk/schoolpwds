<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>faculty, major, and Commune Selection</title>
    <?php
        include("script.php");
        include("connection.php");
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php
    include("admin_sidebar.php");
    ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form action="insert_familybackground.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Background Family
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student's ID</label>
                    <input type="text" class="form-control" name="studentid"
                        value="<?php echo isset($_GET['studentid']) ? $_GET['studentid'] : ''; ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label for="fathername" class="form-label">Father's Name</label>
                    <input type="text" id="fathername" name="fathername" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="fatherage" class="form-label">Father's Age</label>
                    <input type="text" id="fatherage" name="fatherage" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="fatheroccupationid" class="form-label">Father's Occupation</label>
                    <select id="fatheroccupationid" name="fatheroccupationid" class="form-select" required>
                        <option value="">Select Father's Occupation</option>
                        <?php
                $sql_father_occupation = "SELECT occupationid, occupationname FROM tbloccupation";
                $result_father_occupation = mysqli_query($conn, $sql_father_occupation);
                while ($row = mysqli_fetch_assoc($result_father_occupation)) {
                    echo "<option value='{$row['occupationid']}'>{$row['occupationname']}</option>";
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
                while ($row = mysqli_fetch_assoc($result_father_nationality)) {
                    echo "<option value='{$row['nationalityid']}'>{$row['nationalityen']}</option>";
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
                while ($row = mysqli_fetch_assoc($result_father_country)) {
                    echo "<option value='{$row['countryid']}'>{$row['countryen']}</option>";
                }
                ?>
                    </select>
                </div>
                <!-- Mother's fields -->
                <div class="col-lg-6">
                    <label for="mothername" class="form-label">Mother's Name</label>
                    <input type="text" id="mothername" name="mothername" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="motherage" class="form-label">Mother's Age</label>
                    <input type="text" id="motherage" name="motherage" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="motheroccupationid" class="form-label">Mother's Occupation</label>
                    <select id="motheroccupationid" name="motheroccupationid" class="form-select" required>
                        <option value="">Select Mother's Occupation</option>
                        <?php
                $sql_mother_occupation = "SELECT occupationid, occupationname FROM tbloccupation";
                $result_mother_occupation = mysqli_query($conn, $sql_mother_occupation);
                while ($row = mysqli_fetch_assoc($result_mother_occupation)) {
                    echo "<option value='{$row['occupationid']}'>{$row['occupationname']}</option>";
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
                while ($row = mysqli_fetch_assoc($result_mother_nationality)) {
                    echo "<option value='{$row['nationalityid']}'>{$row['nationalityen']}</option>";
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
                while ($row = mysqli_fetch_assoc($result_mother_country)) {
                    echo "<option value='{$row['countryid']}'>{$row['countryen']}</option>";
                }
                ?>
                    </select>
                </div>
                <!-- Remaining fields -->
                <div class="col-lg-6">
                    <label for="familycurrentaddress" class="form-label">Family's Current Address</label>
                    <input type="text" id="familycurrentaddress" name="familycurrentaddress" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="spousename" class="form-label">Spouse's Name</label>
                    <input type="text" id="spousename" name="spousename" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="spouseage" class="form-label">Spouse's Age</label>
                    <input type="text" id="spouseage" name="spouseage" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="guardianphonenumber" class="form-label">Guardian's Phone Number</label>
                    <input type="tel" id="guardianphonenumber" name="guardianphonenumber" class="form-control">
                </div>
                <!-- <div class="col-lg-6">
                    <label for="studentid" class="form-label">Student ID</label>
                    <input type="text" id="studentid" name="studentid" class="form-control">
                </div> -->
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <!-- <a class="btn bg-primary text-white m-0" href="form_student.php">
                        Cancel</a> -->
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
</body>

</html>