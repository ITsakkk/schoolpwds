<?php
include("connection.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // show data from database
            if(!isset($_GET['facultyid'])){
                Header("Location: display_major.php");
                exit;
            }
            $facultyid = $_GET['facultyid'];
            // read data from database
            $query = "SELECT * FROM tblfaculty where facultyid = $facultyid";     
            $rs_result = mysqli_query ($conn, $query);
            $row = $rs_result->fetch_assoc();
            if(!$row){
                Header("Location: display_faculty.php");
                exit;
            }
            $facultykh = $row['facultykh'];
            $facultyen = $row['facultyen'];
    }else {
            $facultyid = $_POST['facultyid'];
            $facultykh = $_POST['facultykh'];
            $facultyen = $_POST['facultyen'];
            $sql = "Update tblfaculty set facultykh='$facultykh',facultyen='$facultyen' Where facultyid = $facultyid";
            $result = $conn->query($sql);
            if(!$result){
                $ErrorMessage = "Invalid Query: ". $conn->error;
            }
            header("location: display_faculty.php");
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
                    Edit Faculty
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">ID</label>
                    <input type="text" value="<?php echo $facultyid ?>" name="facultyid" id="" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Faculty KH</label>
                    <input type="text" name="facultykh" id="" value="<?php echo $facultykh ?>" class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Faculty EN</label>
                    <input type="text" name="facultyen" value="<?php echo $facultyen ?>" id="" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_faculty.php">
                        Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>