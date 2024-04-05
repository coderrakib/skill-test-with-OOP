<?php
	require_once ('../connect.php');

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
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/jquery/jquery-ui.min.js"></script>
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
                            <h2 class="pageheader-title">Add Question Limitation
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">
                                  Add New Limitation
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">New Limitation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="" method="POST">
                                            <select name="category" class="form-control mb-2" required="required">
                                              <option value="">Select Exam Name</option>
                                              <?php

                                                  $sql  = "SELECT * FROM question_category WHERE parent_id = 0";
                                                  $query  = $mysqli->query($sql);

                                                  while($row = $query->fetch_assoc()){

                                                    echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
                                                  }
                                              ?>
                                            </select>
                                            <select name="topic" class="form-control mb-2" required="required">
                                                <option value="">Select Exam Topic Choose Exam Name First</option>
                                            </select>
                                            <select name="level" class="form-control mb-2">
                                              <option value="">Select Exam Difficulty Level</option>
                                              <option value="Beginner">Beginner</option>
                                              <option value="Intermediate">Intermediate</option>
                                              <option value="Advance">Advance</option>
                                              <option value="Expert">Expert</option>
                                            </select>
                                            <input type="text" name="q_limit" class="form-control" placeholder="Enter Question Limitation">
                                        </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input type ="submit" name ="submit" class="btn btn-primary" value="Save">
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><?php echo "<a href='dashboard.php?admin_id=$admin_id' class='breadcrumb-link'>Dashboard</a>";?></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add Question Limitation</li>
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

                    if(isset($_POST['submit']) && $_POST['submit'] === 'Save'){

                        $category       = $_POST['category'];
                        $topic          = $_POST['topic'];
                    	$level 		    = $_POST['level'];
                    	$q_limit		= $_POST['q_limit'];
                    	date_default_timezone_set('Asia/Dhaka');
                    	$create_date 	= date('d-m-Y');

                    	$messages 		= [];

                    	if(isset($category,$topic,$level,$q_limit,$create_date)){

                    		if(empty($category)){

                    			$messages[]		= 'Question Category is Required';
                    		}
                            if(empty($topic)){

                                $messages[]     = 'Question Topic is Required';
                            }
                            if(empty($level)){

                                $messages[]     = 'Question Level is Required';
                            }

                            if(empty($q_limit)){

                                $messages[]     = 'Question Limitation is Required';
                            }

                    		if(!empty($messages)){

                    			$_SESSION['messages'] 	= $messages;
                    			$_SESSION['class_name']	= 'alert-danger';
                    			require_once('include/messages.php');  

                    		}else{

                    			$sql = "INSERT INTO question_limitation (q_category,q_topic,q_level,q_limit,create_date) VALUES ('$category','$topic','$level','$q_limit','$create_date')";

                    			if($mysqli->query($sql)){

                    				$messages[]		= 'Question Limitation Created Successfully';
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
               <!-- ============================================================== -->
                <!-- horizontal form -->
                <!-- ============================================================== -->
	           <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2 col-md-12 col-sm-12 col-12">
	                <div class="card">
	                    <h5 class="card-header">Question Limitation Lists</h5>
	                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                      <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Question Category</th>
                                          <th scope="col">Question Topic</th>
                                          <th scope="col">Question Level</th>
                                          <th scope="col">Question Limitation</th>
                                          <th scope="col">Date</th>
                                          <th scope="col">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php

                                            $sql        = "SELECT * FROM question_limitation";

                                            $query      = $mysqli->query($sql);
                                            $sn         = 1;
                                            while ($result = $query->fetch_assoc()) {
                                                        
                                                $id         = $result['id'];
                                                $q_category = $result['q_category'];
                                                $q_topic    = $result['q_topic'];
                                                $q_level    = $result['q_level'];
                                                $q_limit    = $result['q_limit'];
                                                $date       = $result['create_date'];
          
                                                echo"<tr>
                                                    <td> $sn </td>
                                                    <td> $q_category </td>
                                                    <td> $q_topic </td>
                                                    <td> $q_level </td>
                                                    <td> $q_limit </td>
                                                    <td> $date </td>
                                                    
                                                    <td> 
                                                        <a href='edit_question_limitation.php?admin_id=$admin_id&id=$id' class='btn btn-success mb-2 btn-sm btn-block'><i class='fas fa-edit'></i></a>
                                                        <!-- Button trigger modal -->
                                                        <button type='button' class='btn btn-danger btn-sm btn-block' data-toggle='modal' data-target='#deleteModal-$id'>
                                                            <i class='fas fa-trash-alt'></i>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class='modal fade' id='deleteModal-$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                            <div class='modal-dialog' role='document'>
                                                                <div class='modal-content'>
                                                                      <div class='modal-header'>
                                                                        <h5 class='modal-title' id='exampleModalLabel'>Question Limitation Delete</h5>
                                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                          <span aria-hidden='true'>&times;</span>
                                                                        </button>
                                                                      </div>
                                                                      <div class='modal-body text-danger'>
                                                                        <p class='d-inline'> Do You Want to Delete </p> <span class='d-inline'> $q_level Limitation </span>
                                                                      </div>
                                                                        <div class='modal-footer'>
                                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
                                                                            <form action='question_limitation_delete.php?admin_id=$admin_id&id=$id' method='POST'>
                                                                                <input type ='submit' name ='submit' class='btn btn-primary' value='Yes'>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </td>
                                                    </tr>";   
                                                $sn++;
                                            }
                                        ?>
                                      </tbody>
                                    </table>
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
</body>

</html>