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
                            <h2 class="pageheader-title">Add Question Category
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">
                                  Add New Category
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="" method="POST">
                                            <select name="parent_id" class="form-control mb-3">
                                                <option value="">Choose Your Parent Category</option>
                                                <?php

                                                	$sql 	= "SELECT * FROM question_category";
                                                	$query 	= $mysqli->query($sql);

                                                	foreach ($query as $value) {
                                                		
                                                		echo "<option value='$value[id]'>$value[category_name]</option>";
                                                	}
                                                ?>
                                            </select>
                                            <input type="text" name="category" class="form-control" placeholder="Enter Category Name">
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
                                        <li class="breadcrumb-item active" aria-current="page">Add Question Category</li>
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

                    	$parent_id 		= isset($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
                    	$category		= $_POST['category'];
                    	date_default_timezone_set('Asia/Dhaka');
                    	$create_date 	= date('d-m-Y');

                    	$messages 		= [];

                    	if(isset($parent_id,$category,$create_date)){

                    		if(empty($category)){

                    			$messages[]		= 'Question Category Name is Required';
                    		}

                    		if(!empty($messages)){

                    			$_SESSION['messages'] 	= $messages;
                    			$_SESSION['class_name']	= 'alert-danger';
                    			require_once('include/messages.php');  

                    		}else{

                    			$sql = "INSERT INTO question_category (category_name,parent_id,create_date) VALUES ('$category','$parent_id','$create_date')";

                    			if($mysqli->query($sql)){

                    				$messages[]		= 'Question Category Created Successfully';
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
	                    <h5 class="card-header">Question Category Lists</h5>
	                        <div class="card-body row_position">
                            <?php 

                                function categoryTree($parent_id = 0, $submark = ''){

                                    global $mysqli;
                                    global $admin_id;

                                    $sql    = "SELECT * FROM question_category WHERE parent_id = $parent_id ORDER BY position_order";
                                    $query  = $mysqli->query($sql);

                                    if($query->num_rows > 0){

                                        while ($row = $query->fetch_assoc()) {
                                             
                                            $id 			= $row['id'];
                                            $category_name  = $row['category_name'];

                                            echo "<ul id ='$id' class='p-1 m-0'>
                                                    <li class='pt-1 $submark' style='list-style:none; background:#ddd;'>
                                                        <h5 class='pl-3 p-0 d-inline-block'> $category_name </h5>
                        
                                                        <button type='button' class='btn btn-danger btn-sm float-right ml-1 mr-1' data-toggle='modal' data-target='#deleteModal-$row[id]'>
                                                          <i class='fas fa-trash-alt'></i></i>
                                                        </button>
                                                        <div class='modal fade' id='deleteModal-$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                          <div class='modal-dialog' role='document'>
                                                            <div class='modal-content'>
                                                              <div class='modal-header'>
                                                                <h4 class='modal-title' id='exampleModalLabel'>Delete Category</h4>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                  <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                              </div>
                                                              <div class='modal-body'>
                                                                <h5 class='text-danger'> Do You Want to Delete $category_name ? </h5>
                                                              </div>
                                                              <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                <form action='question_category_delete.php?admin_id=$admin_id&id=$row[id]' method='POST'>
                                                                    <input type='submit' name='submit' class='btn btn-primary' value='Yes'>
                                                                </form>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <button type='button' class='btn btn-success btn-sm float-right' data-toggle='modal' data-target='#editModal-$row[id]'>
                                                          <i class='fas fa-edit'></i>
                                                        </button>
                                                        <div class='modal fade' id='editModal-$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                          <div class='modal-dialog' role='document'>
                                                            <div class='modal-content'>
                                                              <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Edit Category</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                  <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                              </div>
                                                              <div class='modal-body'>
                                                               <form action='question_category_update.php?admin_id=$admin_id&id=$row[id]' method='POST'>
                                                                    <input type='text' class='form-control' name='category' value='$row[category_name]'>
                                                              </div>
                                                              <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                <input type='submit' name='submit' class='btn btn-primary' value='Update'>
                                                              </div>
                                                              </form>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </li>
                                                </ul>";
                                                categoryTree($id,$submark."ml-4");
                                            }
                                        }
                                    }
                                echo categoryTree();    
                                ?>
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
	 $( ".row_position" ).sortable({
		 delay: 150,
		 stop: function() {
		 var selectedData = new Array();
		 $('.row_position>li').each(function() {
		 selectedData.push($(this).attr("id"));
		 });
		 updateOrder(selectedData);
		 }
	 });
		function updateOrder(data) {
			 $.ajax({
			 url:"category_ajaxPro.php",
			 type:'post',
			 data:{position:data},
			 success:function(){
			 alert('Your Change Successfully Saved');
			 }
		 })
	 }
</script>
    <?php require_once('include/js.php'); ?>
</body>

</html>