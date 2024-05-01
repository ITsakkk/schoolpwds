<?php
include("connection.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // show data from database
            if(!isset($_GET['subjectid'])){
                Header("Location: subject_display.php");
                exit;
            }
            $subjectid = $_GET['subjectid'];
            // read data from database
            $query = "SELECT * FROM tblsubject where subjectid = $subjectid";     
            $rs_result = mysqli_query ($conn, $query);
            $row = $rs_result->fetch_assoc();
            if(!$row){
                Header("Location: subject_display.php");
                exit;
            }
            $subjectkh = $row['subjectkh'];
            $subjecten = $row['subjecten'];
            $creditnumber = $row['creditnumber'];
            $hour = $row['hours'];
            $faculytid = $row['facultyid'];
            $majorid = $row['majorid'];
            $yearid = $row['yearid'];
            $semesterid = $row['semesterid'];
    }else {
            $subjectid = $_POST['subjectid'];
            $subjectkh = $_POST['subjectkh'];
            $subjecten = $_POST['subjecten'];
            $creditnumber = $_POST['creditnumber'];
            $hour = $_POST['hours'];
            $facultyid = $_POST['faculty'];
            $majorid = $_POST['majorid'];
            $yearid = $_POST['yearid'];
            $semesterid = $_POST['semesterid'];
            $sql = "Update tblsubject set subjectkh='$subjectkh',subjecten='$subjecten',creditnumber= '$creditnumber', hours= '$hour', facultyid= '$facultyid', majorid='$majorid', yearid='$yearid', semesterid='$semesterid' Where subjectid = $subjectid";
            $result = $conn->query($sql);
            if(!$result){
                $ErrorMessage = "Invalid Query: ". $conn->error;
            }
            header("location: display_subject.php");
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>faculty, major Selection</title>
    <?php
        include("script.php");
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php include("admin_sidebar.php"); ?>
    <!-- end of sidebar -->
    <div class="content px-4 pb-2">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Edit Subject
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">ID</label>
                    <input type="text" value="<?php echo $subjectid ?>" name="subjectid" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject name in Khmer</label>
                    <input type="text" name="subjectkh" id="" value="<?php echo $subjectkh ?>" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Subject name in English</label>
                    <input type="text" name="subjecten" value="<?php echo $subjecten ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Credit Number</label>
                    <input type="text" name="creditnumber" value="<?php echo $creditnumber ?>" id=""
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Hours</label>
                    <input type="text" name="hours" value="<?php echo $hour ?>" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="faculty" class="form-label">Select facultys</label>
                    <select name="faculty" class="form-control" id="faculty">
                        <option value="">Select faculty</option>
                        <?php
            $query = "SELECT * FROM tblfaculty";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <option value='<?php echo $row['facultyid'] ?>'
                            <?php if($faculytid==$row["facultyid"]) echo ' selected="selected"'; ?>>
                            <?php echo $row['facultyen']?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <?php
                    $query = "SELECT * FROM tblmajor where majorid = $majorid";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <label for="major" class="form-label">Select Majors</label>
                    <select name="majorid" class="form-control" id="major">
                        <option value="<?php echo $row['majorid'] ?>">
                            <?php echo $row['majoren'] ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="year" class="form-label">Select Year</label>
                    <select name="yearid" class="form-control" id="year">
                        <?php
                    $query = "SELECT * FROM tblyear";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <option value="<?php echo $row['yearid'] ?>"
                            <?php if($yearid==$row["yearid"]) echo ' selected="selected"'; ?>>
                            <?php echo $row['yearen'] ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label for="semester" class="form-label">Select semester</label>
                    <select name="semesterid" class="form-control" id="semester">
                        <?php
                    $query = "SELECT * FROM tblsemester";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <option value="<?php echo $row['semesterid'] ?>"
                            <?php if($semesterid==$row["semesterid"]) echo ' selected="selected"'; ?>>
                            <?php echo $row['semesteren'] ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_subject.php">
                        Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
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