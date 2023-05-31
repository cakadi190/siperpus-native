<?php 

require_once "../../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../../login.php");
}

// Get User Data
$user = $auth->getUser();

// Count All Stored Book
$borrowLists = $db->getConnection()->prepare("SELECT books.name, penalties.* FROM penalties JOIN books ON penalties.book_id = books.id WHERE penalties.borrower_id = ?");
$borrowLists->bind_param('s', $user['id']);
$borrowLists->execute();
$borrowListsResult = $borrowLists->get_result();

?><!DOCTYPE html>
<html lang="en">

<head>
  <base href="https://<?=$_SERVER['SERVER_NAME'] ?>/panel-assets/" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>My Penalties - Siperpus</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpus <sup>v1</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Perpustakaan
      </div>

      <!-- Nav Item - Borrow and Book List -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>My Books</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Main Menu</h6>
            <a class="collapse-item" href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard/books">Book List</a>
            <a class="collapse-item" href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard/my-borrows">Borrow List</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - My Penalties -->
      <li class="nav-item">
        <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard/my-penalties" class="nav-link">
          <i class="fas fa-fw fa-exclamation-triangle"></i>
          <span>My Penalties</span>
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
            <h1 class="h3 mb-0 text-gray-800">List of Available Books</h1>
          </div>

          <!-- Alert if is Admin -->
          <?php if($user['role'] == 'admin') : ?>
          <div class="alert alert-warning">
            <h4>Warning</h4>
            <p class="mb-3">You are now logged in as admin. Please login to this panel to easily manage any data!</p>
            
            <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/admin" class="btn btn-warning">Go To Admin</a>
          </div>
          <?php endif; ?>
          <!-- Alert if is Admin -->

          <!-- Content Wrapper -->
          <div class="card table-responsive shadow">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Reason</th>
                  <th>Penalty Fee</th>
                  <th>Status</th>
                  <th>Paid Date</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <?php if($borrowListsResult->num_rows === 0) : ?>
                <tr>
                  <td colspan="6" class="text-center">Woops! Data isn't found!</td>
                </tr>
                <?php else : while($data = $borrowListsResult->fetch_assoc()) : ?>
                <tr>
                  <td><?=$data['id'] ?></td>
                  <td>Late return <a href="https://<?=$_SERVER['SERVER_NAME'] ?>/dashboard/books/show.php?id=<?=$data['book_id'] ?>"><?=$data['name'] ?></a> on <?=date("l, j F Y", strtotime($data['return_date'])); ?></td>
                  <td><?=number_format($data['penalty_fee'], 2, ',', '.'); ?>IDR</td>
                  <td><?php
                  if($data['paid_status'] === 0) {
                    echo "<span class=\"badge badge-danger\">Unpaid</span>";
                  } elseif($data['paid_status'] === 2) {
                    echo "<span class=\"badge badge-warning\">Verify Process</span>";
                  } elseif($data['paid_status'] === 1) {
                    echo "<span class=\"badge badge-success\">Paid</span>";
                  }
                  ?></td>
                  <td><?=$data['paid_date'] ? date('l, j F Y', strtotime($data['paid_date'])) : '&mdash;'; ?></td>
                  <td><?php
                  if($data['paid_status'] === 0) {
                    echo "<a class=\"btn btn-success\" href=\"https://". $_SERVER['SERVER_NAME'] ."/dashboard/my-penalties/pay.php?id={$data['id']}\">Pay Now</a>";
                  } elseif($data['paid_status'] === 2) {
                    echo "<a class=\"btn disabled btn-warning\">Pay Now</a>";
                  } elseif($data['paid_status'] === 1) {
                    echo "<a class=\"btn disabled btn-success\">Pay Now</a>";
                  }
                  ?></td>
                </tr>
                <?php endwhile; endif; ?>
              </tbody>
            </table>
          </div>
          <!-- Content Wrapper -->

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

  <script>
    function confirmBooking(e, b) {
      e.preventDefault();
      if(confirm("Do you wanna to borrow this book?")) window.location.href = b.getAttribute('href');
    }
  </script>

</body>

</html>