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
        <form action="insert_student.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Student
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="nameinkhmer" class="form-label">Name in Khmer</label>
                    <input type="text" id="nameinkhmer" name="nameinkhmer" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="nameinlatin" class="form-label">Name in Latin</label>
                    <input type="text" id="nameinlatin" name="nameinlatin" class="form-control" required>
                </div>

                <div class="col-lg-6">
                    <label for="familyname" class="form-label">Family Name</label>
                    <input type="text" id="familyname" name="familyname" class="form-control" required>
                </div>

                <div class="col-lg-6">
                    <label for="givenname" class="form-label">Given Name</label>
                    <input type="text" id="givenname" name="givenname" class="form-control" required>
                </div>

                <?php
    // Database connection
    include("connection.php");

    // Fetch data for dropdowns
    $sql_sex = "SELECT * FROM tblsex";
    $sql_nationality = "SELECT * FROM tblnationality";
    $sql_country = "SELECT * FROM tblcountry";
    $sql_status = "SELECT * FROM tblstatus";

    // Execute queries
    $result_sex = mysqli_query($conn, $sql_sex);
    $result_status = mysqli_query($conn, $sql_status);
    $result_nationality = mysqli_query($conn, $sql_nationality);
    $result_country = mysqli_query($conn, $sql_country);
    ?>

                <div class="col-lg-6">
                    <label for="sexid" class="form-label">Sex</label>
                    <select id="sexid" name="sexid" class="form-select" required>
                        <option value="">Select Sex</option>
                        <?php
            // Generate options for Sex dropdown
            while ($row = mysqli_fetch_assoc($result_sex)) {
                echo "<option value='{$row['sexid']}'>{$row['sexen']}</option>";
            }
            ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="idpassportno" class="form-label">ID/Passport Number</label>
                    <input type="text" id="idpassportno" name="idpassportno" class="form-control">
                </div>

                <!-- Add other input fields based on your requirements -->

                <div class="col-lg-6">
                    <label for="nationalityid" class="form-label">Nationality</label>
                    <select id="nationalityid" name="nationalityid" class="form-select" required>
                        <option value="">Select Nationality</option>
                        <?php
            // Generate options for Nationality dropdown
            while ($row = mysqli_fetch_assoc($result_nationality)) {
                echo "<option value='{$row['nationalityid']}'>{$row['nationalityen']}</option>";
            }
            ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="countryid" class="form-label">Country</label>
                    <select id="countryid" name="countryid" class="form-select" required>
                        <option value="">Select Country</option>
                        <?php
            // Generate options for Country dropdown
            while ($row = mysqli_fetch_assoc($result_country)) {
                echo "<option value='{$row['countryid']}'>{$row['countryen']}</option>";
            }
            ?>
                    </select>
                </div>

                <!-- Add other input fields and dropdowns as needed -->

                <div class="col-lg-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control" required>
                </div>

                <div class="col-lg-6">
                    <label for="pob" class="form-label">Place of Birth</label>
                    <input type="text" id="pob" name="pob" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="phonenumber" class="form-label">Phone Number</label>
                    <input type="tel" id="phonenumber" name="phonenumber" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="currentaddress" class="form-label">Current Address</label>
                    <input type="text" id="currentaddress" name="currentaddress" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="currentaddresspp" class="form-label">Current Address (Permanent)</label>
                    <input type="text" id="currentaddresspp" name="currentaddresspp" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" id="photo" name="photo" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="registerdate" class="form-label">Register Date</label>
                    <input type="date" id="registerdate" name="registerdate" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="statusid" class="form-select" required>
                        <option value="">Select Status</option>
                        <?php
            // Generate options for Sex dropdown
            while ($row = mysqli_fetch_assoc($result_status)) {
                echo "<option value='{$row['statusid']}'>{$row['description']}</option>";
            }
            ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <!-- <a class="btn bg-primary text-white m-0" href="display_student.php">
                        Cancel</a> -->
                    <input type="submit" value="Submit" class="btn btn-primary m-0">
                </div>
            </div>
        </form>

    </div>
</body>

</html>