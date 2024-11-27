<?php
include 'db.php';
session_start();

// Fetch the existing record if an indicator_code is provided
if (isset($_GET['indicator_code'])) {
    $indicator_code = $_GET['indicator_code'];
    
    // Prepare and execute the fetch statement
    $stmt = $pdo->prepare("SELECT * FROM maintenance_area_indicators WHERE indicator_code = ?");
    $stmt->execute([$indicator_code]);
    $indicator = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the indicator exists
    if (!$indicator) {
        $_SESSION['error'] = "Indicator entry not found.";
        header("Location: index_indicatorf.php");
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $governance_code = $_POST['governance_code'];
    $desc_keyctr = $_POST['desc_keyctr'];
    $area_description = $_POST['area_description'];
    $indicator_description = $_POST['indicator_description'];
    $relevance_def = $_POST['relevance_def'];
    $min_requirement = isset($_POST['min_requirement']) ? 1 : 0; // Checkbox handling
    $trail = 'Updated at ' . date('Y-m-d H:i:s');

    // Prepare and execute the update statement
    $stmt = $pdo->prepare("UPDATE maintenance_area_indicators SET 
        governance_code = ?, 
        desc_keyctr = ?, 
        area_description = ?, 
        indicator_description = ?, 
        relevance_def = ?, 
        min_requirement = ?, 
        trail = ? 
        WHERE indicator_code = ?");
    
    if ($stmt->execute([$governance_code, $desc_keyctr, $area_description, $indicator_description, $relevance_def, $min_requirement, $trail, $indicator_code])) {
        $_SESSION['success'] = "Indicator entry updated successfully!";
        header("Location: index_indicatorf.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to update indicator entry.";
    }
}
?>
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
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index_main.html">
                <div class="sidebar-brand-icon">
                    <i><img src="../Logo.png" height="60px"></i>
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="../setup_criteria/index_sc.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Set-Up Criteria</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
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
                        <a class="collapse-item" href="governance.html">Governance</a> -->
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
                                <a class="dropdown-item" href="../index.html" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!--Header-->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Area Indicators</h1>
                    </div>
                <!-- Begin Page Content -->
                <form method="post">
    <label for="governance_code">Governance Code:</label>
    <input type="text" name="governance_code" value="<?php echo htmlspecialchars($indicator['governance_code']); ?>" required>
    <br>

    <label for="desc_keyctr">Description Key:</label>
    <input type="text" name="desc_keyctr" value="<?php echo htmlspecialchars($indicator['desc_keyctr']); ?>" required>
    <br>

    <label for="area_description">Area Description:</label>
    <input type="text" name="area_description" value="<?php echo htmlspecialchars($indicator['area_description']); ?>" required>
    <br>

    <label for="indicator_description">Indicator Description:</label>
    <input type="text" name="indicator_description" value="<?php echo htmlspecialchars($indicator['indicator_description']); ?>" required>
    <br>

    <label for="relevance_def">Relevance Definition:</label>
    <input type="text" name="relevance_def" value="<?php echo htmlspecialchars($indicator['relevance_def']); ?>" required>
    <br>

    <label for="min_requirement">Minimum Requirement:</label>
    <input type="checkbox" name="min_requirement" value="1" <?php echo $indicator['min_requirement'] ? 'checked' : ''; ?> >
    <br>

    <button type="submit">Update Indicator Entry</button>
</form>
                </div>
               <!--End Page Content-->

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>