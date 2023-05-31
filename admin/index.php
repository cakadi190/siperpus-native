<?php 

require_once "../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../login.php");
}

// Get User Data
$user = $auth->getUser();
if($user['role'] !== 'admin') {
  return header('Location: ../dashboard');
}

// Count borrowed book
$countBorrow = $db->getConnection()->prepare("SELECT * FROM borrowers");
$countBorrow->execute();
$countBorrowResult = $countBorrow->get_result()->num_rows;

// Count penalties book
$countPenalties = $db->getConnection()->prepare("SELECT * FROM penalties");
$countPenalties->execute();
$countPenaltiesResult = $countPenalties->get_result()->num_rows;

// Count All Stored Book
$countBooks = $db->getConnection()->prepare("SELECT * FROM books");
$countBooks->execute();
$countBooksResult = $countBooks->get_result()->num_rows;

// Count Moneytary
$moneytary = $db->getConnection()->prepare("SELECT sum(penalty_fee) as total FROM penalties");
$moneytary->execute();
$moneytaryResult = $moneytary->get_result()->fetch_assoc();

?><!DOCTYPE html>
<html lang="en">

<head>
  <base href="https://<?=$_SERVER['SERVER_NAME'] ?>/panel-assets/" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Home - Siperpus</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpus <sup>v1</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - admin -->
      <li class="nav-item">
        <a class="nav-link" href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard Home</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - admin -->
      <li class="nav-item">
        <a class="nav-link" href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard">
          <i class="fas fa-fw fa-arrow-left"></i>
          <span>End User Panel</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Data Manager
      </div>

      <!-- Nav Item - Borrow and Book List -->
      <li class="nav-item">
        <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/books" class="nav-link">
          <i class="fas fa-fw fa-book"></i>
          <span>Book List</span>
        </a>
      </li>

      <!-- Nav Item - My Penalties -->
      <li class="nav-item">
        <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/penalties" class="nav-link">
          <i class="fas fa-fw fa-exclamation-triangle"></i>
          <span>Penalties</span>
        </a>
      </li>

      <!-- Nav Item - Users -->
      <li class="nav-item">
        <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/users" class="nav-link">
          <i class="fas fa-fw fa-users"></i>
          <span>User Manager</span>
        </a>
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

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$user['surname'] ?></span>
                <img class="img-profile rounded-circle" src="http://www.gravatar.com/avatar/<?=md5($user['surname']) ?>" />
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- Coming soon
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
                <div class="dropdown-divider"></div> -->
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- My Borrow -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/borrows" class="card border-left-primary text-decoration-none text-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Borrowed Book</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=numberAbbr($countBorrowResult) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Total Books -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/books" class="card border-left-success text-decoration-none text-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Book Library</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=numberAbbr($countBooksResult) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Total Books -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/penalties" class="card border-left-danger text-decoration-none text-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Penalties</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=numberAbbr($countPenaltiesResult) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Moneytary -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin/penalties" class="card border-left-warning text-decoration-none text-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Moneytary</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=numberAbbr($moneytaryResult['total']) ?> IDR</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Siperpus by <a href="https://www.cakadi.my.id">Cak Adi</a>.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>