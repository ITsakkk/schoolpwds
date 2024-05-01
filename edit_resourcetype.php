<?php
include("connection.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // show data from database
            if(!isset($_GET['ResourceTypeID'])){
                Header("Location: display_resourcetype.php");
                exit;
            }
            $ResourceTypeID = $_GET['ResourceTypeID'];
            // read data from database
            $query = "SELECT * FROM tblresourcetype where ResourceTypeID = $ResourceTypeID";     
            $rs_result = mysqli_query ($conn, $query);
            $row = $rs_result->fetch_assoc();
            if(!$row){
                Header("Location: display_resourcetype.php");
                exit;
            }
            $ResourceTypeName = $row['ResourceTypeName'];
    }else {
            $ResourceTypeID = $_POST['ResourceTypeID'];
            $ResourceTypeName = $_POST['ResourceTypeName'];
            $sql = "Update tblresourcetype set ResourceTypeName='$ResourceTypeName' Where ResourceTypeID = $ResourceTypeID";
            $result = $conn->query($sql);
            if(!$result){
                $ErrorMessage = "Invalid Query: ". $conn->error;
            }
            header("location: display_resourcetype.php");
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
                    Edit Resource Type
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-6">
                    <label for="" class="form-label">ID</label>
                    <input type="text" value="<?php echo $ResourceTypeID ?>" name="ResourceTypeID" id=""
                        class="form-control">
                </div>
                <div class="col-lg-6">
                    <label for="" class="form-label">Resource Type</label>
                    <input type="text" name="ResourceTypeName" value="<?php echo $ResourceTypeName ?>" id=""
                        class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_resourcetype.php">
                        Cancel</a>
                    <input type="submit" value="Update" class="btn bg-primary text-white">
                </div>
            </div>
        </form>
    </div>
</body>

</html>