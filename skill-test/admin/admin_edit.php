<?php
    require_once('../connect.php');
    
    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

    $admin_id     = (int) $_GET['admin_id'];

    $sql    = "SELECT * FROM admin WHERE id = $admin_id";
    $query  = $mysqli->query($sql);
    $result = $query->fetch_assoc();
    $admin_name     = base64_decode($result['admin_name']);
    $admin_email    = $result['admin_email'];
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

        if(isset($_POST['submit']) && $_POST['submit'] === 'Update My Account'){

            $aname      = $_POST['aname'];
            $hash_name  = base64_encode($_POST['aname']);
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

            $messages       = [];

            if(isset($aname,$email,$pass,$con_pass,$image)){

                if(empty($aname) && empty($email) && empty($pass) && empty($con_pass) && empty($image)){

                    $messages[] = 'All Fields are Required';
                }
                else{

                    if(empty($aname)){

                        $messages[] = 'Admin Name is Required';
                    }
                    if(empty($email)){

                        $messages[] = 'Your Email is Required';
                    }
                    if(empty($pass)){

                        //$errors = 'Your Password is Required';
                    }
                    elseif (strlen($pass) < 8 ) {
                        
                        $messages[] = 'Password must be greater than 8 characters long';
                    }
                    elseif ($pass <> $con_pass) {
                        
                        $messages[] = 'Password and Confirm Password is not match';
                    }
                    if(empty($image)){

                        //$errors[] = 'User Image is Required';
                    }
                    elseif(!in_array($extension, $allowed_ext)){

                        $messages[] = 'We are only excepting jpeg , jpg , png images';
                    }
                    elseif($image > $allowed_size){

                        $messages[] = 'We are only 1MB image size';
                    }
                }
                if(!empty($messages)){

                    $_SESSION['messages']   = $messages;
                    $_SESSION['class_name'] = 'alert-danger';

                    require_once('include/messages.php');  
                }
                else{

                    $sql = "UPDATE admin SET admin_name = '$hash_name', admin_email = '$email'";

                    if(!empty($pass)){

                        $sql .= ", admin_pass = '$hash_pass'";
                    }

                    if(!empty($image)){

                        $sql .= ", image = '$new_name'";
                    }

                    $sql .=" WHERE id = '$admin_id'";
                                                
                    if( $mysqli->query($sql) ){

                        $messages[] = "Admin Information Successfully Updated";

                        $_SESSION['messages']   = $messages;
                        $_SESSION['class_name'] = 'alert-success';

                        require_once('include/messages.php'); 

                        header("Refresh:2; url= setting.php?admin_id=$admin_id");

                        if(!empty($image)){

                            move_uploaded_file($image_tmp_name, $directory.$new_name);
                            }
                        }
                    else{

                        echo "<div class='alert alert-danger'>";
                            echo "<strong> Something is Worng !</strong>";
                        echo "</div>";
                        }
                    }
                }
            }
        ?>
        <div class="card">
            <div class="card-header text-center">
            <?php echo "<a href='setting.php?admin_id=$admin_id'><center><img style='margin-top: -10px;' src='image/logo/your school.png' alt='Not found'></center></a>"; ?>
                <p>Please Update user or admin information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="aname"  placeholder="Username" autocomplete="off" value="<?php echo $admin_name;?>">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email"  placeholder="E-mail" autocomplete="off" value="<?php echo $admin_email;?>">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="pass"  placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="confirm"  placeholder="Confirm">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="file" name="image"  placeholder="Confirm">
                </div>
                <div class="form-group pt-2">
                    <input type="submit" name="submit" value="Update My Account" class="btn btn-block btn-primary">
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="index.php" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>   
</body>
<?php require_once('include/js.php'); ?>
</html>