<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin | View Patients</title>

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
	<?php
	$page_title = 'Admin | View Patients';
	$x_content = true;
	?>
	<?php include('include/header.php');?>
	<div class="row">
		<div class="col-md-12">
			<h5 class="over-title margin-bottom-15">View <span class="text-bold">Patients</span></h5>

            <table class="table table-hover" id="sample-table-1">
    <thead>
        <tr>
            <th class="center">#</th>
            <th>Mã bệnh nhân nội trú</th>
			<th>Họ tên</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
            <th>Ngày nhập viện</th>
            <th>Ngày xuất viện</th>
            <th>Phòng bệnh</th>
         
      
            <th>Hoạt động</th>
        </tr>
    </thead>
    <tbody>
	<?php
// Truy vấn dữ liệu từ bảng bn_noitru và bảng benhnhan
$sql = mysqli_query($con, "
    SELECT 
        bn_noitru.maBenhAnNoiTru,
        bn_noitru.ngayNhapVien,
        bn_noitru.ngayXuatVien,
        bn_noitru.phongBenh,
        bn_noitru.chiPhi,
      
        bn_noitru.maBenhNhan,
        benhnhan.hoTen,
        benhnhan.ngaySinh,
        benhnhan.gioiTinh
    FROM bn_noitru
    INNER JOIN benhnhan ON bn_noitru.maBenhNhan = benhnhan.maBenhNhan
");

$cnt = 1;
while ($row = mysqli_fetch_array($sql)) {
    ?>
    <tr>
        <td class="center"><?php echo $cnt; ?>.</td>
        <td class="hidden-xs"><?php echo $row['maBenhAnNoiTru']; ?></td>
		     <td><?php echo $row['hoTen']; ?></td> <!-- Hiển thị họ tên bệnh nhân -->
        <td><?php echo $row['ngaySinh']; ?></td> <!-- Hiển thị ngày sinh bệnh nhân -->
        <td><?php echo $row['gioiTinh']; ?></td> <!-- Hiển thị giới tính bệnh nhân -->
        <td><?php echo $row['ngayNhapVien']; ?></td>
        <td><?php echo $row['ngayXuatVien']; ?></td>
        <td><?php echo $row['phongBenh']; ?></td>
      
   
        <td>
            <a href="view-inpatient.php?viewid=<?php echo $row['maBenhAnNoiTru']; ?>"><i class="fa fa-eye"></i></a>
        </td>
    </tr>
    <?php
    $cnt++;
}
?>

    </tbody>
</table>

      

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