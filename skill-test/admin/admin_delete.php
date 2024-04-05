<?php

require_once('../connect.php');

$admin_id = (int) $_GET['admin_id'];

$sql    = "SELECT * FROM admin WHERE id = $admin_id";
$query  = $mysqli->query($sql);
$result = $query->fetch_assoc();
$admin_name     = base64_decode($result['admin_name']);

if(isset($_POST['submit']) && $_POST['submit'] == 'YES, Delete Information') {

    $sql        = "DELETE FROM admin WHERE id = $admin_id ";

    if( $mysqli->query($sql) ) {
        echo "<script> alert ('Successfully Deleted In $admin_name Information') </script>";
        header("Refresh:2; url= index.php");
    } else {
        echo "<div class='alert alert-danger'>Something wen't wrong</div>";
    }   
} elseif(isset($_POST['submit']) && $_POST['submit'] == 'NO') {
    //header("Refresh:3; url=select-all.php");
    header("Location: setting.php?admin_id=$admin_id");
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once('include/title.php'); ?>
</head>
<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php require_once('include/navbar.php'); ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php require_once('include/leftsidebar.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title"> Delete Admin Information </h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pages</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"> Delete Admin Information </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5">
                        <h4 class="alert alert-danger">Do you want to delete <?php echo $admin_name ;?> information?</h4>
                            <form action="admin_delete.php?admin_id=<?php echo $admin_id;?>" method="POST">
                                <input type="submit" name="submit" value="YES, Delete Information" class="btn btn-danger">
                                <input type="submit" name="submit" value="NO" class="btn btn-success">
                            </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php require_once('include/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <?php require_once('include/js.php'); ?>
</body>
</html>