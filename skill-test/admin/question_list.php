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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                            <h2 class="pageheader-title">Question Lists</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><?php echo "<a href='dashboard.php?admin_id=$admin_id' class='breadcrumb-link'>Dashboard</a>";?></li>
                                        <li class="breadcrumb-item active" aria-current="page">Question Lists </li>
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
	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	              	<div class="card">
	              		<div class="card-header">
						 <ul class="nav nav-tabs card-header-tabs">
						    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#mcq">MCQ</a></li>
						    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#gap">Gap Filling</a></li>
						    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rearrange">Rearrange</a></li>
						  </ul>
						</div>
						<div class="card-body">
							<div class="tab-content">
							    <div id="mcq" class="tab-pane fade in active show">
							    	<div class="table-responsive">
								      <table class="table table-bordered text-center">
											<thead>
												<tr>
													<th>#</th>
													<th>Q_Name</th>
													<th>Q_Category</th>
													<th>Q_Level</th>
													<th>Q_Mark</th>
													<th>Q_Time</th>
													<th>Q_Option</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php

													$sql 		= "SELECT * FROM question WHERE q_type = 'MCQ'";
													$query 		= $mysqli->query($sql);
													$sn 		= 1;
													while ($result = $query->fetch_assoc()) {
														
														$q_id		= $result['id'];
														$q_name 	= $result['q_name'];
														$q_category = $result['q_category'];
														$q_topic 	= $result['q_topic'];
														$q_level 	= $result['q_level'];
														$q_mark 	= $result['q_mark'];
														$q_time 	= $result['q_time'];
														$q_option 	= $result['q_option'];

														$sql_2 		= "SELECT * FROM question_category WHERE id = '$q_category'";
														$query_2 	= $mysqli->query($sql_2);

														while ($sub_result = $query_2->fetch_assoc()) {
															
															$category   = $sub_result['category_name'];
															
															echo"<tr>
															<td> $sn </td>
															<td> $q_name </td>
															<td> $category </td>
															<td> $q_level </td>
															<td> $q_mark </td>
															<td> $q_time </td>
															<td> $q_option </td>
															<td> <a href='edit_question_mcq&gap.php?admin_id=$admin_id&id=$q_id' class='btn btn-success btn-sm btn-block'><i class='fas fa-edit'></i></a>
																<!-- Button trigger modal -->
								                                <button type='button' class='btn btn-danger btn-sm btn-block' data-toggle='modal' data-target='#mcqModal-$q_id'>
								                                  <i class='fas fa-trash-alt'></i>
								                                </button>
								                                <!-- Modal -->
								                                <div class='modal fade' id='mcqModal-$q_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								                                  <div class='modal-dialog' role='document'>
								                                    <div class='modal-content'>
								                                      <div class='modal-header'>
								                                        <h5 class='modal-title' id='exampleModalLabel'>Question Delete</h5>
								                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								                                          <span aria-hidden='true'>&times;</span>
								                                        </button>
								                                      </div>
								                                      <div class='modal-body text-danger'>
								                                      	<p class='d-inline'> Do You Want to Delete </p> <span class='d-inline'> $q_name ? </span>
								                                      </div>
								                                        <div class='modal-footer'>
								                                          	<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
								                                          	<form action='question_delete.php?admin_id=$admin_id&id=$q_id' method='POST'>
								                                            	<input type ='submit' name ='submit' class='btn btn-primary' value='Yes'>
								                                            </form>
								                                        </div>
								                                    </div>
								                                </div>
								                                </div>
															</td>
														</tr>";
														}
														$sn++;
													}
												?>
											</tbody>
										</table>
									</div>
							    </div>
							    <div id="gap" class="tab-pane fade">
							      <table class="table table-bordered text-center">
										<thead>
											<tr>
												<th>#</th>
												<th>Q_Name</th>
												<th>Q_Category</th>
												<th>Q_Level</th>
												<th>Q_Mark</th>
												<th>Q_Time</th>
												<th>Q_Option</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php

												$sql 		= "SELECT * FROM question WHERE q_type = 'Gap Filling'";
												$query 		= $mysqli->query($sql);
												$sn 		= 1;
												while ($result = $query->fetch_assoc()) {
													
													$q_id		= $result['id'];
													$q_name 	= $result['q_name'];
													$q_category = $result['q_category'];
													$q_level 	= $result['q_level'];
													$q_mark 	= $result['q_mark'];
													$q_time 	= $result['q_time'];
													$q_option 	= $result['q_option'];

													$sql_2 		= "SELECT * FROM question_category WHERE id = '$q_category'";
													$query_2 	= $mysqli->query($sql_2);
													
													while ($sub_result = $query_2->fetch_assoc()) {
															
														$category   = $sub_result['category_name'];

														echo"<tr>
														<td> $sn </td>
														<td> $q_name </td>
														<td> $category </td>
														<td> $q_level </td>
														<td> $q_mark </td>
														<td> $q_time </td>
														<td> $q_option </td>
														<td> <a href='edit_question_mcq&gap.php?admin_id=$admin_id&id=$q_id' class='btn btn-success btn-sm btn-block'><i class='fas fa-edit'></i></a>
														<!-- Button trigger modal -->
								                        <button type='button' class='btn btn-danger btn-sm btn-block' data-toggle='modal' data-target='#gapModal-$q_id'>
								                            <i class='fas fa-trash-alt'></i>
								                        </button>
								                       <!-- Modal -->
								                        <div class='modal fade' id='gapModal-$q_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								                            <div class='modal-dialog' role='document'>
								                                <div class='modal-content'>
								                                    <div class='modal-header'>
								                                        <h5 class='modal-title' id='exampleModalLabel'>Question Delete</h5>
								                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								                                          <span aria-hidden='true'>&times;</span>
								                                        </button>
								                                      </div>
								                                      <div class='modal-body text-danger'>
								                                      	<p class='d-inline'> Do You Want to Delete </p> <span class='d-inline'> $q_name ? </span>
								                                      </div>
								                                        <div class='modal-footer'>
								                                          	<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
								                                          	<form action='question_delete.php?admin_id=$admin_id&id=$q_id' method='POST'>
								                                            	<input type ='submit' name ='submit' class='btn btn-primary' value='Yes'>
								                                            </form>
								                                        </div>
								                                    </div>
								                                </div>
								                            </div>
														</td>
													</tr>";
													}

													$sn++;
												}
											?>
										</tbody>
									</table>
							    </div>
							    <div id="rearrange" class="tab-pane fade">
							      <table class="table table-bordered text-center">
										<thead>
											<tr>
												<th>#</th>
												<th>Q_Name</th>
												<th>Q_Category</th>
												<th>Q_Level</th>
												<th>Q_Mark</th>
												<th>Q_Time</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php

												$sql 		= "SELECT * FROM question WHERE q_type = 'Rearrange'";
												$query 		= $mysqli->query($sql);
												$sn 		= 1;
												while ($result = $query->fetch_assoc()) {
													
													$q_id		= $result['id'];
													$q_name 	= $result['q_name'];
													$q_category = $result['q_category'];
													$q_level 	= $result['q_level'];
													$q_mark 	= $result['q_mark'];
													$q_time 	= $result['q_time'];

													$sql_2 		= "SELECT * FROM question_category WHERE id = '$q_category'";
													$query_2 	= $mysqli->query($sql_2);
													
													while ($sub_result = $query_2->fetch_assoc()) {
															
														$category   = $sub_result['category_name'];

														echo"<tr>
														<td> $sn </td>
														<td> $q_name </td>
														<td> $category </td>
														<td> $q_level </td>
														<td> $q_mark </td>
														<td> $q_time </td>
														
														<td> <a href='edit_question_rearrange.php?admin_id=$admin_id&id=$q_id' class='btn btn-success btn-sm btn-block'><i class='fas fa-edit'></i></a>
														<!-- Button trigger modal -->
								                        <button type='button' class='btn btn-danger btn-sm btn-block' data-toggle='modal' data-target='#rearModal-$q_id'>
								                            <i class='fas fa-trash-alt'></i>
								                        </button>
								                       <!-- Modal -->
								                        <div class='modal fade' id='rearModal-$q_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								                            <div class='modal-dialog' role='document'>
								                                <div class='modal-content'>
								                                    <div class='modal-header'>
								                                        <h5 class='modal-title' id='exampleModalLabel'>Question Delete</h5>
								                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								                                          <span aria-hidden='true'>&times;</span>
								                                        </button>
								                                      </div>
								                                      <div class='modal-body text-danger'>
								                                      	<p class='d-inline'> Do You Want to Delete </p> <span class='d-inline'> $q_name ? </span>
								                                      </div>
								                                        <div class='modal-footer'>
								                                          	<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
								                                          	<form action='question_delete.php?admin_id=$admin_id&id=$q_id' method='POST'>
								                                            	<input type ='submit' name ='submit' class='btn btn-primary' value='Yes'>
								                                            </form>
								                                        </div>
								                                    </div>
								                                </div>
								                            </div>
														</td>
													</tr>";
													}
													
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
    		$('table').DataTable();
    	});
    </script>
    <?php require_once('include/js.php'); ?>
</body>
</html>