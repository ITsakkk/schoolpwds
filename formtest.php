<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>
</head>

<body>
    <h2>Student Information Form</h2>
    <form action="insert_data.php" method="POST">
        <!-- Student Information -->
        <h3>Student Information</h3>
        <label for="nameinkhmer">Name in Khmer:</label>
        <input type="text" id="nameinkhmer" name="nameinkhmer" required><br>

        <!-- Add other fields for student information -->

        <!-- Family Background -->
        <h3>Family Background</h3>
        <label for="fathername">Father's Name:</label>
        <input type="text" id="fathername" name="fathername" required><br>

        <!-- Add other fields for family background -->

        <!-- Educational Background -->
        <h3>Educational Background</h3>
        <label for="schoolname">School Name:</label>
        <input type="text" id="schoolname" name="schoolname" required><br>

        <!-- Add other fields for educational background -->

        <input type="submit" value="Submit">
    </form>
</body>

</html>