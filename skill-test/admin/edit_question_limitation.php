<?php

    require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

    $admin_id       = (int) $_GET['admin_id'];
    $q_id           = (int) $_GET['id'];

    $sql            = "SELECT * FROM question_limitation WHERE id= '$q_id'";
    $query          = $mysqli->query($sql);
    $result         = $query->fetch_assoc();
    $q_category     = $result['q_category'];
    $q_topic        = $result['q_topic'];
    $q_level        = $result['q_level'];
    $q_limit        = $result['q_limit'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('include/title.php'); ?>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
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
                        <div class="page-header mt-2">
                            <h2 class="pageheader-title">Edit Question Limitation</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><?php echo "<a href='dashboard.php?admin_id=$admin_id' class='breadcrumb-link'>Dashboard</a>";?></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Question Limitation </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
               <!-- ============================================================== -->
                <!-- horizontal form -->
                <!-- ============================================================== -->
	             <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2 col-md-12 col-sm-12 col-12">
	                <div class="card">
	                    <h5 class="card-header">Edit Question Limitation</h5>
	                        <div class="card-body">
	                       <form action="question_limitation_update.php?admin_id=<?php echo $admin_id; ?>&id=<?php echo $q_id; ?>" method="POST" enctype="multipart/form-data">
	                           <div class="form-group row">
	                               <div class="col-12">
	                                   <label class="mb-2"> Question Category </label>
	                                   <select name="category" class="form-control">
                                        <option value="">Choose Question Category</option>
	                                       <?php

                                                $sql  = "SELECT * FROM question_category WHERE parent_id = 0";
                                                $query  = $mysqli->query($sql);

                                                while ($result = $query->fetch_assoc())
                                                {
                                                            
                                                $value  = $result['category_name'];
                                                $id     = $result['id'];

                                                if($id == $q_category)
                                                    {
                                                        echo "<option selected='selected' value='".$id."'>".$value."</option>";
                                                    }
                                                else
                                                {
                                                    echo "<option value='".$id."'>".$value."</option>";
                                                    }
                                                }
                                            ?>
                                            </select>
	                                       </div>
	                                    </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label class="mb-2"> Question Topic </label>
                                                <select name="topic" class="form-control">
                                                    <option value="">Choose Question Category First</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label class="mb-2"> Question Difficulty level</label>
                                                    <select name="level" class="form-control">
                                                        <option value="">Choose Question Level</option>
                                                        <option value="Beginner" <?php if($q_level == 'Beginner') echo 'selected="selected"'; ?> >Beginner</option>
                                                        <option value="Intermediate" <?php if($q_level == 'Intermediate') echo 'selected="selected"'; ?> >Intermediate</option>
                                                        <option value="Advance" <?php if($q_level == 'Advance') echo 'selected="selected"'; ?> >Advance</option>
                                                        <option value="Expert" <?php if($q_level == 'Expert') echo 'selected="selected"'; ?> >Expert</option>
                                                </select>
                                            </div>
                                        </div>
	                                    
	                                    <div class="form-group row">
	                                        <div class="col-12">
	                                            <label class="mb-2"> Question Limit </label>
	                                            <input type="text" name="limit" class="form-control" value="<?php echo $q_limit ?>">
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group row">              
                                            <div class="col-12 pl-0 mt-5">
                                                <p class="text-right">
                                                    <input type="submit" name="submit" value="Update"  class="btn btn-space btn-primary">
                                                    <input type="reset"  name="reset"  value="Cancel"  class="btn btn-space btn-secondary">
                                                </p>
                                           </div>
                                        </div>
	                            </form>
	                        </div>
	                    </div>
                	</div>
            	</div>
            <!-- ============================================================== -->
            <!-- end horizontal form -->
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
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script type="text/javascript">
        $( "select[name='category']" ).change(function () {
        var categoryID = $(this).val();

        if(categoryID) {

            $.ajax({
                url: "topic_ajaxPro.php",
                dataType: 'Json',
                data: {'id':categoryID},
                success: function(data) {
                    $('select[name="topic"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="topic"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });


        }else{

            $('select[name="topic"]').empty();
        }
    });
        
    </script>
<?php require_once('include/js.php'); ?>
</body>
</html>