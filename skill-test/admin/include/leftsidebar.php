<?php

    $admin_id  = (int) $_GET['admin_id'];

?>
<!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <?php echo "<a class='nav-link' href='dashboard.php?admin_id=$admin_id'><i class='fa fa-home'></i>Dashboard</a>";?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-question-circle"></i>Make Question</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='add_question.php?admin_id=$admin_id'>Add Question</a>";?>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='question_list.php?admin_id=$admin_id'>Question Lists</a>";?>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='question_category.php?admin_id=$admin_id'>Question Category</a>";?>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='question_limitation.php?admin_id=$admin_id'>Question Limitation</a>";?>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Chart</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='view_comment.php?admin_id=$admin_id'>Comment</a>"; ?>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='view_reply.php?admin_id=$admin_id'>Reply</a>"; ?>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Blog</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='upload_blog.php?admin_id=$admin_id'>Upload Blog</a>";?>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo "<a class='nav-link' href='view_blog.php?admin_id=$admin_id'>View Blog</a>";?>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->