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
        <form role="form" method="post" name="search">
            <div class="form-group">
                <label for="tenNV">
                    Select Doctor (Tên bác sĩ)
                </label>
            <select name="maNV" id="maNV" class="form-control" required='true'>
    <option value="">Chọn bác sĩ</option>
    <?php
    // Truy vấn lấy danh sách tên bác sĩ từ bảng nhanvien
    $sql_nv = "SELECT maNV, hoTen FROM nhanvien";
    $result_nv = mysqli_query($con, $sql_nv);
    while ($row_nv = mysqli_fetch_array($result_nv)) {
        echo "<option value='{$row_nv['maNV']}'>{$row_nv['hoTen']}</option>";
    }
    ?>
</select>

            </div>
            <button type="submit" name="search" id="submit" class="btn btn-o btn-primary">
                Search
            </button>
        </form>
        
        <?php
       if (isset($_POST['search'])) {
		// Lấy maNV từ form chọn bác sĩ
		$maNV = $_POST['maNV'];  // Đảm bảo lấy đúng giá trị từ tên 'maNV'
	
		// Truy vấn tìm các bệnh nhân được điều trị bởi bác sĩ maNV
		$sql = "
		SELECT DISTINCT benhnhan.hoTen, 
						benhnhan.ngaySinh, 
						benhnhan.gioiTinh, 
						benhnhan.soDienThoai, 
						benhnhan.diaChi, 
						benhnhan.LoaiBenhNhan,
						bn_noitru.phongBenh, 
						dieutri.ketQuaDieuTri
		FROM dieutri
		JOIN bn_noitru ON dieutri.maBenhNhan = bn_noitru.maBenhAnNoiTru
		JOIN benhnhan ON bn_noitru.maBenhNhan = benhnhan.maBenhNhan
		WHERE dieutri.maBacSi = '$maNV';";
		
	
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
	
		if ($num > 0) {
			echo "<h4 align='center'>Kết quả tìm kiếm cho bác sĩ với mã \"$maNV\"</h4>";
			echo "<table class='table table-hover' id='sample-table-1'>
					<thead>
						<tr>
							<th class='center'>#</th>
							<th>Tên bệnh nhân</th>
							<th>Ngày sinh</th>
							<th>Giới tính</th>
							<th>Số điện thoại</th>
							<th>Địa chỉ</th>
							<th>Loại bệnh nhân</th>
							<th>Phòng bệnh</th>
							<th>Kết quả điều trị</th>
						</tr>
					</thead>
					<tbody>";
	
			$cnt = 1;
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>
						<td class='center'>$cnt.</td>
						<td>{$row['hoTen']}</td>
						<td>{$row['ngaySinh']}</td>
						<td>{$row['gioiTinh']}</td>
						<td>{$row['soDienThoai']}</td>
						<td>{$row['diaChi']}</td>
						<td>{$row['LoaiBenhNhan']}</td>
						<td>{$row['phongBenh']}</td>
						<td>{$row['ketQuaDieuTri']}</td>
					</tr>";
				$cnt++;
			}
	
			echo "</tbody></table>";
		} else {
			echo "<p>Không tìm thấy bệnh nhân nào điều trị bởi bác sĩ với mã nhân viên \"$maNV\".</p>";
		}
	}
	
        ?>
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