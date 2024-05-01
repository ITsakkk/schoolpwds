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
        <form method="POST" enctype="multipart/form-data" action="insert_subject.php">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Subject
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject name in Khmer</label>
                    <input type="text" name="subjectkh" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject name in English</label>
                    <input type="text" name="subjecten" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Credit Number</label>
                    <input type="text" name="creditnumber" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Hours</label>
                    <input type="text" name="hours" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="faculty" class="form-label">Select facultys</label>
                    <select name="faculty" class="form-control" id="faculty">
                        <option value="">Select faculty</option>
                        <?php
            $query = "SELECT * FROM tblfaculty";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['facultyid']}'>{$row['facultyen']}</option>";
            }
            ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="major" class="form-label">Select Majors</label>
                    <select name="major" class="form-control" id="major" disabled>
                        <option value="">Select faculty First</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="years" class="form-label">Select years</label>
                    <select name="year" class="form-control" id="years">
                        <option value="">Select years</option>
                        <?php
            $query = "SELECT * FROM tblyear";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['yearid']}'>{$row['yearen']}</option>";
            }
            ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="semester" class="form-label">Select semester</label>
                    <select name="semester" class="form-control" id="semester">
                        <option value="">Select semester</option>
                        <?php
            $query = "SELECT * FROM tblsemester";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['semesterid']}'>{$row['semesteren']}</option>";
            }
            ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_subject.php">
                        Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#faculty').change(function() {
            var facultyId = $(this).val();
            if (facultyId) {
                $.ajax({
                    type: 'POST',
                    url: 'fetch_major.php',
                    data: {
                        faculty: facultyId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#major').html(response.options).prop('disabled', false);
                    },
                    error: function() {
                        alert('Error occurred while fetching majors');
                    }
                });
            } else {
                $('#major').html('<option value="">Select faculty First</option>').prop('disabled',
                    true);
            }
        });

    });
    </script>
</body>

</html>