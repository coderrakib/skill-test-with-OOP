<?php

    require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }
    
    $admin_id = (int) $_GET['admin_id'];
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
                            <h2 class="pageheader-title">Admin Information </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pages</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Admin Information</li>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">View Admin Information</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first text-center">
                                        <thead>
                                            <tr>
                                                <th>Admin Id</th>
                                                <th>Admin Name</th>
                                                <th>Admin Email</th>
                                                <th>Admin Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 

                                            require_once ('../connect.php');

                                            $sql        = "SELECT * FROM admin ORDER BY id ASC";
                                            $query      = $mysqli->query($sql);
                                            

                                            while ( $result = $query->fetch_assoc() ) {

                                            $id             = $result['id'];    
                                            $name           = base64_decode($result['admin_name']);
                                            $email          = $result['admin_email'];
                                            $image          = $result['image'];
                                            

                                            if($image){

                                                if(file_exists("image/admin_image/$image")){

                                                    $image = "<center><a href='image/admin_image/$image' class='image-popup'>
                                                        <img src='image/admin_image/$image' class='img-responsive img-thumbnail' width='90'>
                                                        </a></center>";
                                                }else{

                                                    $image = "Not Found";
                                                }
                                            }else{

                                                $image = "Image Not Added";
                                            }
                                            echo '<tbody>';
                                                echo '<tr>';
                                                    echo "<td>$id </td>";
                                                    echo "<td>$name</td>";
                                                    echo "<td>$email</td>";
                                                    echo "<td>$image</td>";
                                                    echo "<td><a href='admin_edit.php?admin_id=$admin_id'><button class='btn btn-success btn-sm'>Edit</button></a>
                                                    	<a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#exampleModalCenter' href='admin_delete.php?admin_id=$admin_id'>Delete</a>
                                                        </td>"; 
                                                echo '</tr>';
                                             echo '</tbody>'; 
                                            }
                                        ?>
                                        <!-- Button trigger modal -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    ...
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary">Yes</button>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>   
                                        <tfoot>
                                            <tr>
                                                <th>Admin Id</th>
                                                <th>Admin Name</th>
                                                <th>Admin Email</th>
                                                <th>Admin Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
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
    <!-- Optional JavaScript -->
    <?php require_once('include/js.php'); ?>
</body>
 
</html>