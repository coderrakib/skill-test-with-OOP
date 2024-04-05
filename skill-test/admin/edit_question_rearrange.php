<?php

    require_once ('../connect.php');

    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

    $admin_id       = (int) $_GET['admin_id'];
    $q_id           = (int) $_GET['id'];

    $sql            = "SELECT * FROM question WHERE id= $q_id";
    $query          = $mysqli->query($sql);
    $result         = $query->fetch_assoc();
    $q_name         = $result['q_name'];
    $q_type         = $result['q_type'];
    $q_category     = $result['q_category'];
    $q_topic        = $result['q_topic'];
    $q_level        = $result['q_level'];
    $q_mark         = $result['q_mark'];
    $q_time         = $result['q_time'];
    $q_answer       = $result['q_answer'];
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
                            <h2 class="pageheader-title">Edit Your Question </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><?php echo "<a href='dashboard.php?admin_id=$admin_id' class='breadcrumb-link'>Dashboard</a>";?></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Your Question </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <?php 

                    if(isset($_POST['submit']) && $_POST['submit'] === 'Submit'){

                    	$q_name 		= $_POST['editor1'];
                    	$q_category 	= $_POST['category'];
                    	$q_type 		= $_POST['type'];
                        $q_topic        = $_POST['topic'];
                        $q_level        = $_POST['level'];
                    	$q_mark			= $_POST['mark'];
                    	$q_time 		= $_POST['time'];
                    	$q_answer 		= $_POST['answer'];
                    	date_default_timezone_set('Asia/Dhaka');
                    	$update_date 	= date('d-m-Y');

                    	$messages 		= [];

                    	if(isset($q_name,$q_category,$q_type,$q_topic,$q_level,$q_mark,$q_time,$update_date)){

                    		if(empty($q_name) && empty($q_category) && empty($q_type) && empty($q_topic) && empty($q_level) && empty($q_mark) && empty($q_time) && empty($q_answer)){

                    			$messages[]		= 'All Question Fields is Required';

                    		}else{

                    			if(empty($q_name)){

                    				$messages[]	= 'Question Name is Required';
                    			}
                    			if(empty($q_category)){

                    				$messages[]	= 'Question Category is Required';
                    			}
                    			if(empty($q_type)){

                    				$messages[]	= 'Question Type is Required';
                    			}
                                if(empty($q_topic)){

                                    $messages[] = 'Question Topic is Required';
                                }
                                if(empty($q_level)){

                                    $messages[] = 'Question Level is Required';
                                }
                    			if(empty($q_mark)){

                    				$messages[]	= 'Question Mark is Required';
                    			}
                    			if(empty($q_time)){

                    				$messages[]	= 'Question Time is Required';
                    			}

                    			if(empty($q_answer)){

                    				$messages[]	= 'Question Answer is Required';
                    			}
                    		}

                    		if(!empty($messages)){

                    			$_SESSION['messages'] 	= $messages;
                    			$_SESSION['class_name']	= 'alert-danger';
                    			require_once('include/messages.php');  

                    		}else{


                    			$sql = "UPDATE question SET q_name = '$q_name', q_type = '$q_type', q_category = '$q_category', q_topic = '$q_topic', q_level = '$q_level', q_mark = '$q_mark', q_time = '$q_time', q_answer = '$q_answer', update_date = '$update_date' WHERE id = '$q_id'";

                    			if($mysqli->query($sql)){

                    				$messages[]		= 'Question Updated Successfully';
                    				$_SESSION['messages'] 	= $messages;
                    				$_SESSION['class_name']	= 'alert-primary';
                    				require_once('include/messages.php');

                    			}else{

                    				$messages[]		= 'Somethings is Wrong';
                    				$_SESSION['messages'] 	= $messages;
                    				$_SESSION['class_name']	= 'alert-danger';
                    				require_once('include/messages.php');
                    			}
                    		}
                    	}
                    }

                ?>
               <!-- ============================================================== -->
                <!-- horizontal form -->
                <!-- ============================================================== -->
	             <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2 col-md-12 col-sm-12 col-12">
	                <div class="card">
	                    <h5 class="card-header">Edit Your Question</h5>
	                        <div class="card-body">
	                            <form action="" method="POST" enctype="multipart/form-data">
	                                <div class="form-group row">
	                                    <div class="col-12">
	                                        <label class="mb-2"> Question Name </label>
	                                         <textarea class="form-control" name="editor1"><?php echo strip_tags($q_name) ;?></textarea>
	                                        	<script>
	                                            	CKEDITOR.replace( 'editor1' );
	                                        	</script>
	                                        </div>
	                                    </div>
	                                    <div class="form-group row">
	                                        <div class="col-12">
	                                            <label class="mb-2"> Question Type </label>
	                                            <select name="type" class="form-control">
                                                	<option value="">Choose Question Type</option> 
                                                	<option value="Rearrange" <?php if($q_type == 'Rearrange') echo 'selected="selected"'; ?> >Rearrange</option> 
                                            </select>
	                                        </div>
	                                    </div>
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
	                                            <label class="mb-2"> Question Mark </label>
	                                            <input type="text" name="mark" class="form-control" value="<?php echo $q_mark ?>">
	                                        </div>
	                                    </div>
	                                    <div class="form-group row">
	                                        <div class="col-12">
	                                            <label class="mb-2"> Question Time </label>
	                                            <input type="text" name="time" class="form-control" value="<?php echo $q_time ?>">
	                                        </div>
	                                    </div>
	                                    <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Answer </label>
                                                    <textarea class="form-control" name="answer"><?php echo $q_answer; ?></textarea>
                                               <div class="col-12 pl-0 mt-5">
                                                   <p class="text-right">
                                                       <input type="submit" name="submit" value="Submit"  class="btn btn-space btn-primary">
                                                       <input type="reset"  name="reset"  value="Cancel"  class="btn btn-space btn-secondary">
                                                   </p>
                                           </div>
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

    	/*$(document).ready(function(){
    		var i = 1;
    		$('#add').click(function(){
    			i++;
    			$('#dynamic_field').append('<div id="id'+i+'" class="input-group mb-3"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" name="answer[]" value="'+i+'"></div></div><input type="text" name="option[]" class="form-control" placeholder="Enter Your Option"> <button class="btn btn-danger btn_remove btn-sm ml-3" name="remove" id="'+i+'"> X </button></div>'
    			);
    		});

    		$(document).on('click','.btn_remove', function(){
    			var button_id = $(this).attr("id");
    			$('#id'+button_id+'').remove();
    		});
    	});*/

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