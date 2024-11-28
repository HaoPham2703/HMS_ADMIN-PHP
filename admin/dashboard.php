<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
// Truy vấn số lượng bác sĩ
$resultDoctors = mysqli_query($con, "SELECT COUNT(*) AS totalDoctors FROM nhanvien WHERE loaiNhanVien = 'Bác sĩ'");
$rowDoctors = mysqli_fetch_assoc($resultDoctors);
$totalDoctors = $rowDoctors['totalDoctors'];

// Truy vấn số lượng y tá
$resultNurses = mysqli_query($con, "SELECT COUNT(*) AS totalNurses FROM nhanvien WHERE loaiNhanVien = 'Y tá'");
$rowNurses = mysqli_fetch_assoc($resultNurses);
$totalNurses = $rowNurses['totalNurses'];

// Truy vấn số lượng bệnh nhân
$resultPatients = mysqli_query($con, "SELECT COUNT(*) AS totalPatients FROM benhnhan");
$rowPatients = mysqli_fetch_assoc($resultPatients);
$totalPatients = $rowPatients['totalPatients'];

// Truy vấn số lượng thuốc
$resultMedicines = mysqli_query($con, "SELECT COUNT(*) AS totalMedicines FROM thuoc");
$rowMedicines = mysqli_fetch_assoc($resultMedicines);
$totalMedicines = $rowMedicines['totalMedicines'];

// Truy vấn số lượng khoa
$resultDepartments = mysqli_query($con, "SELECT COUNT(*) AS totalDepartments FROM khoa");
$rowDepartments = mysqli_fetch_assoc($resultDepartments);
$totalDepartments = $rowDepartments['totalDepartments'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin  | Dashboard</title>
  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../assets/css/custom.min.css" rel="stylesheet">
</head>
<body class="nav-md">
  <?php include('include/header.php');?>
  <div class="tile_count">
  <div class="row">
    <div class="col-md-2 col-sm-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-user-md"></i> Số lượng bác sĩ</span>
        <div class="count"><?php echo $totalDoctors; ?></div>
    </div>
    <div class="col-md-2 col-sm-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Số lượng y tá</span>
        <div class="count"><?php echo $totalNurses; ?></div>
    </div>
    <div class="col-md-2 col-sm-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-users"></i> số lượng bệnh nhân</span>
        <div class="count"><?php echo $totalPatients; ?></div>
    </div>
    <div class="col-md-2 col-sm-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-list-alt"></i> Số lượng thuốc</span>
        <div class="count"><?php echo $totalMedicines; ?></div>
    </div>
    <div class="col-md-2 col-sm-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-building"></i> Số lượng khoa</span>
        <div class="count"><?php echo $totalDepartments; ?></div>
    </div>
</div>
  </div>


  <?php include('include/footer.php');?>
  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="../vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="../vendors/Flot/jquery.flot.js"></script>
  <script src="../vendors/Flot/jquery.flot.pie.js"></script>
  <script src="../vendors/Flot/jquery.flot.time.js"></script>
  <script src="../vendors/Flot/jquery.flot.stack.js"></script>
  <script src="../vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="../vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="../assets/js/custom.min.js"></script>
</body>
</html>