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
	<link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
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
	<?php include('include/header.php'); ?>
	<div class="row">
		<div class="col-md-12">
			<form role="form" method="post" name="search">
				<div class="form-group">
					<label for="maBenhNhan">
						Search by Patient ID (maBenhNhan)
					</label>
					<input type="text" name="searchdata" id="searchdata" class="form-control" value="" required='true'>
				</div>
				<button type="submit" name="search" id="submit" class="btn btn-o btn-primary">
					Search
				</button>
			</form>

			<?php
if (isset($_POST['search'])) {
    $sdata = $_POST['searchdata'];

    // Chuẩn bị câu truy vấn an toàn để lấy thông tin bệnh nhân
    $stmt = $con->prepare("
        SELECT 
            bn.maBenhNhan, 
            bn.hoTen, 
            bn.soDienThoai,
            COUNT(bn.soDienThoai) AS soLanKham,
            IFNULL(dt.ketQuaDieuTri, nt.chanDoan) AS thongTinDieuTri
        FROM 
            benhnhan bn
        LEFT JOIN 
            bn_ngoaitru nt ON bn.maBenhNhan = nt.maBenhNhan
        LEFT JOIN 
            dieutri dt ON bn.maBenhNhan = dt.maBenhNhan
        WHERE 
            bn.maBenhNhan = ?
        GROUP BY 
            bn.maBenhNhan
    ");

    // Gán tham số và thực thi
    $stmt->bind_param("s", $sdata);
    $stmt->execute();
    $result = $stmt->get_result();

    $num = $result->num_rows;
    if ($num > 0) {
        echo "<h4 align='center'>Kết quả tìm kiếm cho mã bệnh nhân \"$sdata\"</h4>";
        echo "<table class='table table-hover' id='sample-table-1'>
            <thead>
                <tr>
                    <th class='center'>#</th>
                    <th>Mã số</th>
                    <th>Tên bệnh nhân</th>
                    <th>Số điện thoại</th>
                    <th>Thông tin điều trị</th>
                    <th>Số lần khám</th>
                </tr>
            </thead>
            <tbody>";

        $cnt = 1;
        while ($row = $result->fetch_assoc()) {
            // Truy vấn thứ hai: Lấy ketQuaDieuTri có maDieuTri nhỏ nhất
            $maBenhNhan = $row['maBenhNhan'];

            // Chuẩn bị câu truy vấn để lấy ketQuaDieuTri từ bảng dieutri
            $stmt2 = $con->prepare("
                SELECT 
                    dt.ketQuaDieuTri
                FROM 
                    dieutri dt
                WHERE 
                    dt.maDieuTri = (
                        SELECT MIN(maDieuTri)
                        FROM dieutri
                        WHERE maBenhNhan = ?
                    )
            ");

            // Gán tham số và thực thi truy vấn thứ hai
            $stmt2->bind_param("s", $maBenhNhan);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            // Lấy ketQuaDieuTri từ kết quả truy vấn thứ hai
            $thongTinDieuTri = "";
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $thongTinDieuTri = $row2['ketQuaDieuTri'];
            }

            // Hiển thị kết quả cho bệnh nhân
            echo "<tr>
                <td class='center'>$cnt.</td>
                <td>{$row['maBenhNhan']}</td>
                <td>{$row['hoTen']}</td>
                <td>{$row['soDienThoai']}</td>
                <td>{$thongTinDieuTri}</td>
                <td>{$row['soLanKham']}</td>
            </tr>";

            $cnt++;
        }
        echo "</tbody></table>";
    } else {
        echo "<tr><td colspan='5'>Không tìm thấy kết quả</td></tr>";
    }
}
?>



		</div>
	</div>

	<?php include('include/footer.php'); ?>
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