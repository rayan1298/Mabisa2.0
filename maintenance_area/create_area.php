<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $trail = 'Created at ' . date('Y-m-d H:i:s');

    // Insert into the database
    $sql = "INSERT INTO maintenance_area (description, trail) VALUES (:description, :trail)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['description' => $description, 'trail' => $trail]);

    // Set success message and redirect
    $_SESSION['success'] = "Area created successfully!";
    header('Location: main.php');
    exit();
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.html">
                <div class="sidebar-brand-icon">
                    <i><img src="../Logo.png" height="60px"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MABISA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.html">
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
                <a class="nav-link collapsed" href="Criteria.html">
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
                        <a class="collapse-item" href="area.html">Area</a>
                        <a class="collapse-item" href="area_description.html">Area Description</a>
                        <a class="collapse-item" href="area_indicator.html">Area Indicators</a>
                        <a class="collapse-item" href="min_req.html">Minimum Requirements</a>
                        <a class="collapse-item" href="sub_req.html">Sub-Requirements</a>
                        <a class="collapse-item" href="category.html">Category</a>
                        <a class="collapse-item" href="version.html">Version</a>
                        <a class="collapse-item" href="docu_source.html">Document Source</a>
                        <a class="collapse-item" href="governance.html">Governance</a>
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Assign Area</h1>
                    </div>
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <!-- <th>Area Number</th> -->
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- rows will be added here dynamically -->
                        </tbody>
                        
                    </table>
                    <form method="POST" action="create_area.php">
                        <label>Description:</label><br>
                        <textarea name="description" required></textarea><br><br>

                        <button type="submit">Add Area</button>
                    </form>
                    <!-- <button id="add-row-btn" class="btn btn-primary">Add</button>
                    <button type="submit" id="save-btn" class="btn btn-success">Save</button>
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script method="POST" action="create_area.php">
                        $(document).ready(function() {
                            // Add row button click event
                            $('#add-row-btn').on('click', function() {
                                var newRow = '<tr>';
                                // newRow += '<td><input type="number" min="0" class="form-control" /></td>';
                                newRow += '<td><input name="description"  type="text" class="form-control" /></td>';
                                newRow += '<td><button class="btn btn-danger delete-btn">Delete</button></td>';
                                newRow += '<td><button class="btn btn-danger delete-btn">Delete1</button></td>';
                                newRow += '</tr>';
                                $('#table-body').append(newRow);
                            });
                        
                            // Save button click event
                            $('#save-btn').on('click', function() {
                                // TO DO: implement save functionality
                                alert('Save button clicked!');
                            });
                        
                            // Delete button click event
                            $(document).on('click', '.delete-btn', function() {
                                $(this).closest('tr').remove();
                            });
                        });
                    </script> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>