<form action="submit_student_info.php" method="POST" enctype="multipart/form-data">
        <label for="nameinlatin">Name in Latin:</label>
        <input type="text" id="nameinlatin" name="nameinlatin" required><br><br>

        <label for="familyname">Family Name:</label>
        <input type="text" id="familyname" name="familyname" required><br><br>

        <label for="givenname">Given Name:</label>
        <input type="text" id="givenname" name="givenname" required><br><br>

        <?php
        // Database connection
        include("connection.php");

        // Fetch data for dropdowns
        $sql_sex = "SELECT * FROM tblsex";
        $sql_nationality = "SELECT * FROM tblnationality";
        $sql_country = "SELECT * FROM tblcountry";

        // Execute queries
        $result_sex = mysqli_query($conn, $sql_sex);
        $result_nationality = mysqli_query($conn, $sql_nationality);
        $result_country = mysqli_query($conn, $sql_country);

        ?>

        <label for="sexid">Sex:</label>
        <select id="sexid" name="sexid" required>
            <option value="">Select Sex</option>
            <?php
            // Generate options for Sex dropdown
            while ($row = mysqli_fetch_assoc($result_sex)) {
                echo "<option value='{$row['sexid']}'>{$row['sexen']}</option>";
            }
            ?>
        </select><br><br>

        <label for="idpassportno">ID/Passport Number:</label>
        <input type="text" id="idpassportno" name="idpassportno"><br><br>

        <!-- Add other input fields based on your requirements -->

        <label for="nationalityid">Nationality:</label>
        <select id="nationalityid" name="nationalityid" required>
            <option value="">Select Nationality</option>
            <?php
            // Generate options for Nationality dropdown
            while ($row = mysqli_fetch_assoc($result_nationality)) {
                echo "<option value='{$row['nationalityid']}'>{$row['nationalityen']}</option>";
            }
            ?>
        </select><br><br>

        <label for="countryid">Country:</label>
        <select id="countryid" name="countryid" required>
            <option value="">Select Country</option>
            <?php
            // Generate options for Country dropdown
            while ($row = mysqli_fetch_assoc($result_country)) {
                echo "<option value='{$row['countryid']}'>{$row['countryen']}</option>";
            }
            ?>
        </select><br><br>

        <!-- Add other input fields and dropdowns as needed -->

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="pob">Place of Birth:</label>
        <input type="text" id="pob" name="pob"><br><br>

        <label for="phonenumber">Phone Number:</label>
        <input type="tel" id="phonenumber" name="phonenumber"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="currentaddress">Current Address:</label>
        <input type="text" id="currentaddress" name="currentaddress"><br><br>

        <label for="currentaddresspp">Current Address (Permanent):</label>
        <input type="text" id="currentaddresspp" name="currentaddresspp"><br><br>

        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo"><br><br>

        <label for="registerdate">Register Date:</label>
        <input type="date" id="registerdate" name="registerdate" required><br><br>

        <input type="submit" value="Submit">
    </form>