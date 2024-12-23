<!-- Script connection -->
<?php
include 'script.php';

$data = [];
$maintenance_area_description_query = "
    SELECT
        maintenance_governance.*,
        maintenance_category.description category,
        maintenance_area.description area_description
    FROM
        `maintenance_governance`
    LEFT JOIN maintenance_category ON maintenance_governance.cat_code = maintenance_category.code
    LEFT JOIN maintenance_area ON maintenance_governance.area_keyctr = maintenance_area.keyctr;
    
    
    ;
";

$maintenance_area_description_result = mysqli_query($conn, $maintenance_area_description_query);



if ($maintenance_area_description_result && mysqli_num_rows($maintenance_area_description_result) > 0) {
    // Fetch and display each row with var_dump
    while ($maintenance_area_description_row = mysqli_fetch_assoc($maintenance_area_description_result)) {

        // maintenance_governance
        $maintenance_governance_query = "SELECT * FROM `maintenance_governance` where desc_keyctr = '$maintenance_area_description_row[keyctr]'";
        $maintenance_governance_result = mysqli_query($conn, $maintenance_governance_query);

        if ($maintenance_governance_result && mysqli_num_rows($maintenance_governance_result) > 0) {
            while ($maintenance_governance_row = mysqli_fetch_assoc($maintenance_governance_result)) {

                $query2_data = $maintenance_governance_row;

                // maintenance_area_indicators
                $maintenance_area_indicators_query = "SELECT * FROM `maintenance_area_indicators` where governance_code = '$maintenance_governance_row[keyctr]'";
                $maintenance_area_indicators_result = mysqli_query($conn, $maintenance_area_indicators_query);



                if ($maintenance_area_indicators_result && mysqli_num_rows($maintenance_area_indicators_result) > 0) {
                    while ($maintenance_area_indicators_row = mysqli_fetch_assoc($maintenance_area_indicators_result)) {

                        $query3_data = $maintenance_area_indicators_row;


                        // maintenance_criteria_setup
                        $maintenance_criteria_setup_query = "
                            SELECT 
                            
                                msc.keyctr AS keyctr,
                                mam.description,
                                mam.reqs_code,
                                msc.movdocs_reqs documentary_requirements,
                                mds.srcdesc data_source


                            FROM `maintenance_criteria_setup` msc 
                            left JOIN maintenance_criteria_version AS mcv
                            ON
                                msc.version_keyctr = mcv.keyctr
                            left JOIN maintenance_area_mininumreqs AS mam
                            ON
                                msc.minreqs_keyctr = mam.keyctr
                            LEFT JOIN maintenance_document_source AS mds
                            ON
                                msc.data_source = mds.keyctr 
                            
                            where msc.indicator_keyctr  = '$maintenance_area_indicators_row[keyctr]'
                            order by mam.reqs_code asc
                            ";
                        $maintenance_criteria_setup_result = mysqli_query($conn, $maintenance_criteria_setup_query);


                        if ($maintenance_criteria_setup_result && mysqli_num_rows($maintenance_criteria_setup_result) > 0) {
                            while ($maintenance_criteria_setup_row = mysqli_fetch_assoc($maintenance_criteria_setup_result)) {

                                $data[$maintenance_area_description_row['category']. " " . $maintenance_area_description_row['area_description']  . ": " . $maintenance_area_description_row['description']][] = array(
                                    'keyctr' => $maintenance_criteria_setup_row['keyctr'],
                                    'indicator_code' => $maintenance_area_indicators_row['indicator_code'],
                                    'indicator_description' => $maintenance_area_indicators_row['indicator_description'],
                                    'relevance_definition' => $maintenance_area_indicators_row['relevance_def'],
                                    'reqs_code' => $maintenance_criteria_setup_row['reqs_code'],
                                    'documentary_requirements' => $maintenance_criteria_setup_row['documentary_requirements'],
                                    'description' => $maintenance_criteria_setup_row['description'],
                                    'data_source' => $maintenance_criteria_setup_row['data_source'],


                                );

                            }
                        }


                    }
                }


            }
        }

    }
}
?>
<!-- end of srcipt connection -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MABISA - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index_main.html">
                <div class="sidebar-brand-icon">
                    <i><img src="../Logo.png" height="60 px"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MABISA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index_main.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Criteria Management
            </div>

            <!-- Nav Item - Criteria -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="index_sc.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Set-Up Criteria</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Criteria Maintenance</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings</h6>
                        <a class="collapse-item" href="../maintenance_area/main.php">Area</a>
                        <a class="collapse-item" href="../maintenance_area_description/index_area_desf.php">Area Description</a>
                        <a class="collapse-item" href="../maintenance_area_indicators/index_indicatorf.php">Area Indicators</a>
                        <!-- <a class="collapse-item" href="min_req.html">Minimum Requirements</a>
                        <a class="collapse-item" href="sub_req.html">Sub-Requirements</a>
                        <a class="collapse-item" href="category.html">Category</a>
                        <a class="collapse-item" href="version.html">Version</a>
                        <a class="collapse-item" href="docu_source.html">Document Source</a>
                        <a class="collapse-item" href="governance.html">Governance</a>s -->
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Barangay Management
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="bar_assessment.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Barangay Assessment</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="location.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Location</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="users.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Users</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="reports.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Generate Report</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="header-title">MABILISANG AKSYON INFORMATION SYSTEM OF ALORAN</div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../index_main.html" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                 <!-- Begin Page Content -->
                 <div class="container">
        <div class="container text-center">
            <div class="row">
                <div class="col-auto me-auto">
                    <h4>Maintenance Criteria Setup</h4>
                </div>
                <div class="col-auto"> <a href="add.php" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <?php

        foreach ($data as $key => $rows) { ?>
            <div class="text-center">
                <h5>
                    <?php echo $key; ?>
                </h5>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Indicator</th>
                        <th>Relevant/Definition </th>
                        <th>Minimum Requirements</th>
                        <th>Documentary Requirements/MOVs</th>
                        <th>Data Source</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {

                        ?>
                        <tr>
                           
                            <td><?php echo $row['indicator_code']." ".  $row['indicator_description']; ?></td>
                            <td><?php echo $row['relevance_definition']; ?></td>
                            <td><?php echo $row['reqs_code'] ." ". $row['description']; ?></td>
                            <td><?php echo $row['documentary_requirements']; ?></td>
                            <td><?php echo $row['data_source']; ?></td>
                            <td>
                                <a href="editf.php?edit_id=<?php echo $row['keyctr'] ?>">Edit</a> |
                                <a href="script.php?delete_id=<?php echo $row['keyctr'] ?>">Delete</a>
                            </td>
                        </tr>

                        <?php
                    } ?>



                </tbody>
            </table>

            <br />
            <br />


            <?php
        }

        ?>

    </div>
            <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</body>

</html>