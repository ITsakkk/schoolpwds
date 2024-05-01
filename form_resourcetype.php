<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include("script.php");
        include_once 'connection.php';
    ?>
</head>

<body>
    <?php
    include("admin_sidebar.php");
    ?>
    <div class="content px-4 pb-2">
        <form method="POST" enctype="multipart/form-data" action="insert_resourcetype.php">
            <div class="row">
                <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                    Add Resource Type
                </div>
            </div>
            <div class="row py-4 bg-light">
                <div class="col-lg-12">
                    <label for="" class="form-label">Input resource type</label>
                    <input type="text" name="ResourceTypeName" id="" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0 py-2">
                    <a class="btn bg-primary text-white m-0" href="display_resourcetype.php">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>

</html>