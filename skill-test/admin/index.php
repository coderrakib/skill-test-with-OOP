<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
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

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
    <?php 

        session_start();

        require_once('../connect.php');

        if(isset($_POST['submit']) && $_POST['submit'] === 'Sign in'){

            $admin       = $_POST['aname'];
            $hash_name   = base64_encode($_POST['aname']);
            $password    = $_POST['password'];
            $hash        = hash('sha512', $password);

            $sql        = "SELECT * FROM admin WHERE admin_name = '$hash_name' AND password = '$hash'";
            $query      = $mysqli->query($sql);
            $row_count  = mysqli_num_rows($query);
            $result     = $query->fetch_assoc();
            $admin_id   = isset($result['id']) ? $result['id'] : 0;
            $name       = $admin;       

            $errors = [];

            if(isset($admin,$password)){

                if(empty($admin) && empty($password)){

                    $errors[] = 'Admin Name and Password is Required';
                }
                else{

                    if(empty($admin)){

                        $errors[] = 'Admin Name is Required';
                    }
                    if(empty($password)){

                        $errors[] = 'Password is Required';
                    }
                }

                if(!empty($errors)){

                    $_SESSION['messages']   = $errors;
                    $_SESSION['class_name'] = 'alert-danger';

                    require_once('include/messages.php'); 
                }
                else{

                    if($row_count == 1){

                        $_SESSION['admin_login'] = true;

                            echo "<script>alert('$name Successfully Login')</script>";
                            echo "<script>window.open('dashboard.php?admin_id=$admin_id','_self')</script>";
                    }
                    else{

                        $errors[] = 'Admin Name or Password is Wrong';
                        $_SESSION['messages']   = $errors;
                        $_SESSION['class_name'] = 'alert-danger';

                        require_once('include/messages.php'); 
                    }
                }
            }
        }
    ?>
        <div class="card ">
            <div class="card-header text-center"><a href="index.php"><center><img style="margin-top: -10px;" src="image/logo/your school.png" alt="Not found"></center></a><span class="splash-description">Please enter your admin information.</span></div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="username" name="aname" type="text" placeholder="Admin Name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <input type="submit" name="submit" value="Sign in" class="btn btn-primary btn-lg btn-block">
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>