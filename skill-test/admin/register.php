<?php
    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

    $admin_id  = (int) $_GET['admin_id'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <?php require_once('include/title.php'); ?>
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" action="" method="POST" enctype="multipart/form-data">
    <?php

        require_once('../connect.php');

        if(isset($_POST['submit']) && $_POST['submit'] === 'Register My Account'){

            $aname      = $_POST['aname'];
            $hash_name	= base64_encode($_POST['aname']);
            $email      = $_POST['email'];
            $pass       = $_POST['pass'];
            $hash_pass  = hash('sha512', $pass);
            $con_pass   = $_POST['confirm'];
            $date       = date('j M Y');
            $image      = $_FILES['image']['name'];
            $image_size      = $_FILES['image']['size'];
            $image_type      = $_FILES['image']['type'];
            $image_tmp_name  = $_FILES['image']['tmp_name'];
            $directory       = 'image/admin_image/';

            $explode        = explode('.', $image);
            $extension      = strtolower(end($explode));
            $allowed_ext    = array('jpeg','jpg','png');
            $allowed_size   = 1048576;
            $new_name       = rand(1000,9999).'.'.$extension;

            $sql = "SELECT * FROM admin WHERE admin_name = '$hash_name' AND admin_email = '$email'";

            $query  = $mysqli->query($sql);

            $row_count = mysqli_num_rows($query);

            $errors     = [];

            if(isset($aname,$email,$pass,$con_pass,$image,$date)){

                if(empty($aname) && empty($email) && empty($pass) && empty($con_pass) && empty($image)){

                    $errors[] = 'All Fields are Required';
                }
                else{

                    if(empty($aname)){

                        $errors[] = 'Admin Name is Required';
                    }
                    if(empty($email)){

                        $errors[] = 'Your Email is Required';
                    }
                    if(empty($pass)){

                        $errors = 'Your Password is Required';
                    }
                    elseif (strlen($pass) < 8 ) {
                        
                        $errors[] = 'Password must be greater than 8 characters long';
                    }
                    elseif ($pass <> $con_pass) {
                        
                        $errors[] = 'Password and Confirm Password is not match';
                    }
                    if(empty($image)){

                        $errors[] = 'User Image is Required !';
                    }
                    elseif(!in_array($extension, $allowed_ext)){

                        $errors[] = 'We are only excepting jpeg , jpg , png images';
                    }
                    elseif($image > $allowed_size){

                    $errors[] = 'We are only 1MB image size';
                    }
                }
                if(!empty($errors)){

                    foreach ($errors as $error) {              
                        echo "<div class='alert alert-danger mb-5'>";
                            echo "<strong>$error</strong>";
                        echo "</div>";
                    }
                }
                else{

                    if($row_count == 1){

                        echo "<div class='alert alert-warning'>";
                            echo "<strong>Admin is Already Register </strong>";
                        echo "</div>";
                        exit();
                    }
                    else{

                        if(move_uploaded_file($image_tmp_name, $directory.$new_name)){

                            $sql = "INSERT INTO admin VALUES('','$hash_name','$email','$hash_pass','$new_name','$date')";                         
                        }
                        else{

                            echo "<div class='alert alert-danger mb-4'>";
                                echo '<strong> We are only 1MB image size !</strong>';
                            echo "</div>";
                            exit(); 
                        }
                    }
                    if( $mysqli->query($sql)){

                        echo "<div class='alert alert-success'>";
                            echo "<strong> Congratulation! $aname Account is Successfully Register. Thank You ....</strong>";
                        echo "</div>";
                        header("Refresh:2; url= setting.php?admin_id=$admin_id");
                    }
                    else{

                        echo "<div class='alert alert-danger'>";
                            echo '<strong> Something Wen\'t Worng </strong>';
                        echo "</div>";
                    }
                }
            }
        }

    ?>
        <div class="card">
            <div class="card-header text-center">
                <?php echo "<a href='dashboard.php?admin_id=$admin_id'><center><img style='margin-top: -10px;' src='image/logo/your school.png' alt='Not found'></center></center></a>" ?>
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user or admin information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="aname"  placeholder="Admin name" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email"  placeholder="E-mail" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="pass"  placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="confirm"  placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="file" name="image"  placeholder="Confirm">
                </div>
                <div class="form-group pt-2">
                    <input type="submit" name="submit" value="Register My Account" class="btn btn-block btn-primary">
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="index.php" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
</body>
</html>