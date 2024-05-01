<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Information</title>
    <?php
    include("script.php");
    include("connection.php");
    ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- End of Sidebar -->

    <div class="content px-4 pb-2">
        <form action="insert_lecturer.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Lecturer
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="nameinkh" class="form-label">Name in Khmer</label>
                    <input type="text" id="nameinkh" name="nameinkh" class="form-control" required>
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
                $sql_degree = "SELECT * FROM tbldegree";
                $sql_sex = "SELECT * FROM tblsex";
                $sql_nationality = "SELECT * FROM tblnationality";
                $sql_country = "SELECT * FROM tblcountry";
                $sql_department = "SELECT * FROM department";
                $sql_status = "SELECT * FROM tblstatus";

                // Execute queries
                $result_degree = mysqli_query($conn, $sql_degree);
                $result_sex = mysqli_query($conn, $sql_sex);
                $result_nationality = mysqli_query($conn, $sql_nationality);
                $result_country = mysqli_query($conn, $sql_country);
                $result_department = mysqli_query($conn, $sql_department);
                $result_status = mysqli_query($conn, $sql_status);
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
                    <label for="passportid" class="form-label">Passport ID</label>
                    <input type="text" id="passportid" name="passportid" class="form-control">
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
                    <label for="professionalexperience" class="form-label">Professional Experience</label>
                    <input type="text" id="professionalexperience" name="professionalexperience" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="degreeid" class="form-label">Academic Degrees</label>
                    <select id="degreeid" name="degreeid" class="form-select" required>
                        <option value="">Select Academic Degree</option>
                        <?php
                        // Generate options for Academic Degrees dropdown
                        while ($row = mysqli_fetch_assoc($result_degree)) {
                            echo "<option value='{$row['degreeid']}'>{$row['degreenameen']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="departmentid" class="form-label">Department</label>
                    <select id="departmentid" name="departmentid" class="form-select" required>
                        <option value="">Select Department</option>
                        <?php
                        // Generate options for Department dropdown
                        while ($row = mysqli_fetch_assoc($result_department)) {
                            echo "<option value='{$row['departmentid']}'>{$row['departmentname']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control" required>
                </div>

                <div class="col-lg-6">
                    <label for="publications" class="form-label">Publications</label>
                    <input type="text" id="publications" name="publications" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="pob" class="form-label">Place of Birth</label>
                    <input type="text" id="pob" name="pob" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" id="photo" name="photo" class="form-control">
                </div>

                <div class="col-lg-6">
                    <label for="statusid" class="form-label">Status</label>
                    <select id="statusid" name="statusid" class="form-select" required>
                        <option value="">Select Status</option>
                        <?php
                        // Generate options for Status dropdown
                        while ($row = mysqli_fetch_assoc($result_status)) {
                            echo "<option value='{$row['statusid']}'>{$row['description']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <input type="submit" value="Submit" class="btn btn-primary m-0">
                </div>
            </div>
        </form>
    </div>
</body>

</html>