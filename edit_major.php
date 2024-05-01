<?php
include("connection.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // show data from database
            if(!isset($_GET['majorid'])){
                Header("Location: display_major.php");
                exit;
            }
            $majorid = $_GET['majorid'];
            // read data from database
            $query = "SELECT * FROM tblmajor where majorid = $majorid";     
            $rs_result = mysqli_query ($conn, $query);
            $row = $rs_result->fetch_assoc();
            if(!$row){
                Header("Location: display_major.php");
                exit;
            }
            $majorkh = $row['majorkh'];
            $majoren = $row['majoren'];
            $faculytid = $row['facultyid'];
    }else {
            $majorid = $_POST['majorid'];
            $majorkh = $_POST['majorkh'];
            $majoren = $_POST['majoren'];
            $facultyid = $_POST['faculty'];
            $sql = "Update tblmajor set majorkh='$majorkh',majoren='$majoren', facultyid= '$facultyid' Where majorid = $majorid";
            $result = $conn->query($sql);
            if(!$result){
                $ErrorMessage = "Invalid Query: ". $conn->error;
            }
            header("location: display_major.php");
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
                    Edit Major
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">ID</label>
                    <input type="text" value="<?php echo $majorid ?>" name="majorid" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Major KH</label>
                    <input type="text" name="majorkh" id="" value="<?php echo $majorkh ?>" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Major EN</label>
                    <input type="text" name="majoren" value="<?php echo $majoren ?>" id="" class="form-control">
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
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_major.php">
                        Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>