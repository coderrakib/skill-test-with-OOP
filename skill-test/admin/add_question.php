<?php
    session_start();

    if(!isset($_SESSION['admin_login'])){

        header("Location:index.php");
    }

    $admin_id  = (int) $_GET['admin_id'];
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
                            <h2 class="pageheader-title">Add Your Question </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><?php echo "<a href='dashboard.php?admin_id=$admin_id' class='breadcrumb-link'>Dashboard</a>";?></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add Your Question </li>
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

                    require_once ('../connect.php');

                    if(isset($_POST['submit']) && $_POST['submit'] === 'Submit'){

                    	$q_name 		= trim($_POST['editor1']);
                    	$q_type 		= $_POST['type'];
                    	$q_category 	= $_POST['category'];
                    	$q_topic 		= $_POST['topic'];
                    	$q_level 		= $_POST['level'];
                    	$q_mark			= $_POST['mark'];
                    	$q_time 		= $_POST['time'];
                    	$q_option		= isset($_POST['option']) ? $_POST['option'] : null;
                    	$q_answer 		= isset($_POST['answer']) ? $_POST['answer'] : null;
                    	date_default_timezone_set('Asia/Dhaka');
                    	$create_date 	= date('d-m-Y');

                    	$messages 		= [];

                    	if(isset($q_name,$q_category,$q_topic,$q_level,$q_type,$q_mark,$q_time,$create_date)){

                    		if(empty($q_name) && empty($q_category) && empty($q_topic) && empty($q_level) && empty($q_type) && empty($q_mark) && empty($q_time) && empty($q_option) && empty($q_answer)){

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

                    				$messages[]	= 'Question Topic is Required';
                    			}
                    			if(empty($q_level)){

                    				$messages[]	= 'Question Level is Required';
                    			}
                    			if(empty($q_mark)){

                    				$messages[]	= 'Question Mark is Required';
                    			}
                    			if(empty($q_time)){

                    				$messages[]	= 'Question Time is Required';
                    			}
                    			if(empty($q_option)){

                    				$messages[]	= 'Question Option is Required';
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

                    			$option 	= implode(',', $q_option);
                    			$answer 	= implode(',', $q_answer);

                    			$sql = "INSERT INTO question (q_name,q_type,q_category,q_topic,q_level,q_mark,q_time,q_option,q_answer,create_date) VALUES ('$q_name','$q_type','$q_category','$q_topic','$q_level','$q_mark','$q_time','$option','$answer','$create_date')";

                    			if($mysqli->query($sql)){

                    				$messages[]		= 'Question Created Successfully';
                    				$_SESSION['messages'] 	= $messages;
                    				$_SESSION['class_name']	= 'alert-success';
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
                 <?php 

                    require_once ('../connect.php');

                    if(isset($_POST['re_submit']) && $_POST['re_submit'] === 'Submit'){

                        $q_name         = trim($_POST['editor1']);
                        $q_category     = $_POST['category'];
                        $q_type         = $_POST['type'];
                        $q_topic 		= $_POST['topic'];
                    	$q_level 		= $_POST['level'];
                        $q_mark         = $_POST['mark'];
                        $q_time         = $_POST['time'];
                        $q_answer       = trim($_POST['answer']);
                        date_default_timezone_set('Asia/Dhaka');
                        $create_date    = date('d-m-Y');

                        $messages       = [];

                        if(isset($q_name,$q_category,$q_topic,$q_level,$q_type,$q_mark,$q_time,$q_answer,$create_date)){

                            if(empty($q_name) && empty($q_category) && empty($q_topic) && empty($q_level) && empty($q_type) && empty($q_mark) && empty($q_time) && empty($q_answer)){

                                $messages[]     = 'All Question Fields is Required';

                            }else{

                                if(empty($q_name)){

                                    $messages[] = 'Question Name is Required';
                                }
                                if(empty($q_category)){

                                    $messages[] = 'Question Category is Required';
                                }
                                if(empty($q_type)){

                                    $messages[] = 'Question Type is Required';
                                }
                                if(empty($q_topic)){

                                    $messages[] = 'Question Topic is Required';
                                }
                                if(empty($q_level)){

                                    $messages[] = 'Question Level is Required';
                                }
                                if(empty($q_mark)){

                                    $messages[] = 'Question Mark is Required';
                                }
                                if(empty($q_time)){

                                    $messages[] = 'Question Time is Required';
                                }

                                if(empty($q_answer)){

                                    $messages[] = 'Question Answer is Required';
                                }
                            }

                            if(!empty($messages)){

                                $_SESSION['messages']   = $messages;
                                $_SESSION['class_name'] = 'alert-danger';
                                require_once('include/messages.php');  

                            }else{      

                                $sql = "INSERT INTO question (q_name,q_type,q_category,q_topic,q_level,q_mark,q_time,q_answer,create_date) VALUES ('$q_name','$q_type','$q_category','$q_topic','$q_level','$q_mark','$q_time','$q_answer','$create_date')";

                                if($mysqli->query($sql)){

                                    $messages[]     = 'Question Created Successfully';
                                    $_SESSION['messages']   = $messages;
                                    $_SESSION['class_name'] = 'alert-success';
                                    require_once('include/messages.php');

                                }else{

                                    $messages[]     = 'Somethings is Wrong';
                                    $_SESSION['messages']   = $messages;
                                    $_SESSION['class_name'] = 'alert-danger';
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
	                    <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#mcq_gap">MCQ & Gap Filling</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rearrange">Rearrange</a></li>
                            </ul>
                        </div>
	                   <div class="card-body">
                            <div class="tab-content">
                                <div id="mcq_gap" class="tab-pane fade in active show">
    	                            <form action="" method="POST" enctype="multipart/form-data">
    	                                <div class="form-group row">
    	                                    <div class="col-12">
    	                                        <label class="mb-2"> Question Name </label>
    	                                         <textarea class="form-control" name="editor1"></textarea>
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
                                                    	<option value="MCQ">MCQ</option> 
                                                    	<option value="Gap Filling">Gap Filling</option>  
                                                </select>
    	                                        </div>
    	                                    </div>
    	                                     <div class="form-group row">
    	                                        <div class="col-12">
    	                                            <label class="mb-2"> Question Category </label>
    	                                            <select name="category" class="form-control">
                                                    	<option value="">Choose Question Category</option>
    	                                                <?php

    	                                                	$sql 	= "SELECT * FROM question_category WHERE parent_id = 0";
    	                                                	$query 	= $mysqli->query($sql);

    	                                                	while($row = $query->fetch_assoc()){

                            									echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
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
                                                    	<option value="Beginner">Beginner</option>
                                                    	<option value="Intermediate">Intermediate</option>
                                                    	<option value="Advance">Advance</option>
                                                    	<option value="Expert">Expert</option>
                                                </select>
    	                                        </div>
    	                                    </div>
    	                                    
    	                                    <div class="form-group row">
    	                                        <div class="col-12">
    	                                            <label class="mb-2"> Question Mark </label>
    	                                            <input type="text" name="mark" class="form-control">
    	                                        </div>
    	                                    </div>
    	                                    <div class="form-group row">
    	                                        <div class="col-12">
    	                                            <label class="mb-2"> Question Time </label>
    	                                            <input type="text" name="time" class="form-control">
    	                                        </div>
    	                                    </div>
    	                                    <div class="form-group row">
    	                                        <div class="col-12">
    	                                            <label class="mb-2"> Question Option & Answer </label>
    	                                            <button type="button" class="btn btn-primary btn-sm ml-3" name="add" id="add">Add More</button>
    	                                            <!-- Group of default radios - option 1 -->
    												<div id="dynamic_field" class="custom-control custom-radio mt-3">
    												  <div class="input-group mb-3">
    	                                                <div class="input-group-prepend">
    	                                                    <div class="input-group-text">
    	                                                      <input type="checkbox" name="answer[]" value="1">
    	                                                    </div>
    	                                                  </div>
    	                                                  <input type="text" name="option[]" class="form-control" placeholder="Enter Your Option">
    	                                                </div>
    	                                            </div>
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
                           <div data-editor="ClassicEditor" data-collaboration="false" id="rearrange" class="tab-pane fade">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label class="mb-2"> Question Name </label>
                                                 <textarea class="form-control editor" name="editor1"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Type </label>
                                                    <select name="type" class="form-control">
                                                        <option value="">Choose Question Type</option> 
                                                        <option value="Rearrange">Rearrange </option> 
                                                </select>
                                                </div>
                                            </div>
                                             <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Category </label>
                                                    <select name="category" class="form-control">
                                                        <option value="">Choose Question Category</option>
                                                        <?php

                                                            $sql    = "SELECT * FROM question_category WHERE parent_id = 0";
                                                            $query  = $mysqli->query($sql);

                                                            while($row = $query->fetch_assoc()){

                            									echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
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
    	                                            <label class="mb-2"> Question Difficulty level </label>
    	                                            <select name="level" class="form-control">
                                                    	<option value="">Choose Question Level</option>
                                                    	<option value="Beginner">Beginner</option>
                                                    	<option value="Intermediate">Intermediate</option>
                                                    	<option value="Advance">Advance</option>
                                                    	<option value="Expert">Expert</option>
                                                </select>
    	                                        </div>
    	                                    </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Mark </label>
                                                    <input type="text" name="mark" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Time </label>
                                                    <input type="text" name="time" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label class="mb-2"> Question Answer </label>
                                                    <textarea class="form-control" name="answer"></textarea>
                                               <div class="col-12 pl-0 mt-5">
                                                   <p class="text-right">
                                                       <input type="submit" name="re_submit" value="Submit"  class="btn btn-space btn-primary">
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

    	$(document).ready(function(){
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
    	});
        
    </script>

    <script>
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

    <script>ClassicEditor
            .create( document.querySelector( '.editor' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                licenseKey: '',
                
            } )
            .then( editor => {
                window.editor = editor;   
            } )
            .catch( error => {
                console.error( 'Oops, something gone wrong!' );
                console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
                console.warn( 'Build id: k2i30chx32nf-8o65j7c6blw0' );
                console.error( error );
            } );
    </script> 
</body>
</html>