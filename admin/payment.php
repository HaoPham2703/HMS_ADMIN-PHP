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
                <label for="soDienThoai">
                    Báo cáo thanh toán
                </label>
                <input type="text" class="form-control" name="soDienThoai" id="soDienThoai" required="true" placeholder="Nhập số điện thoại bệnh nhân">
            </div>
            <button type="submit" name="search" id="submit" class="btn btn-o btn-primary">
                Tìm kiếm
            </button>
        </form>

		<?php
if (isset($_POST['search'])) {
    $soDienThoai = $_POST['soDienThoai'];

    // Truy vấn lấy tất cả bệnh nhân có cùng số điện thoại
    $sql_loai_benhnhan = "
        SELECT hoTen, maBenhNhan, LoaiBenhNhan 
        FROM benhnhan 
        WHERE soDienThoai = '$soDienThoai'";
    $result_loai_benhnhan = mysqli_query($con, $sql_loai_benhnhan);

    if (mysqli_num_rows($result_loai_benhnhan) > 0) {
        echo "<h4 align='center'>Thông tin bệnh nhân</h4>";
        echo "<table border='1' align='center' cellpadding='10' cellspacing='0'>";
        
        // Duyệt qua từng loại bệnh nhân để quyết định cột "Phí khám"
        $first_row = true;
        while ($benhnhan = mysqli_fetch_assoc($result_loai_benhnhan)) {
            $hoTen = $benhnhan['hoTen'];
            $maBenhNhan = $benhnhan['maBenhNhan'];
            $loaiBenhNhan = $benhnhan['LoaiBenhNhan'];

            // Xử lý cột "Phí khám"
            if ($first_row) {
                // Hiển thị cột "Phí khám" chỉ nếu có bệnh nhân ngoại trú
                if ($loaiBenhNhan == "Ngoại Trú") {
                    echo "<tr><th>Họ tên</th><th>Loại bệnh nhân</th><th>Tổng chi phí thuốc (VND)</th><th>Phí khám (VND)</th><th>Danh sách thuốc sử dụng</th></tr>";
                } else {
                    echo "<tr><th>Họ tên</th><th>Loại bệnh nhân</th><th>Tổng chi phí thuốc (VND)</th><th>Danh sách thuốc sử dụng</th></tr>";
                }
                $first_row = false;
            }

            // Xử lý tùy loại bệnh nhân
            if ($loaiBenhNhan == "Nội Trú") {
                // Truy vấn thông tin và tổng chi phí cho bệnh nhân nội trú
                $sql_total_cost = "
                    SELECT SUM(thuoc.giaCa) AS totalCost, 
                           GROUP_CONCAT(thuoc.tenThuoc ORDER BY thuoc.tenThuoc SEPARATOR ', ') AS tenThuocList
                    FROM bn_noitru
                    JOIN dieutri ON bn_noitru.maBenhAnNoiTru = dieutri.maBenhNhan
                    JOIN thuoc ON dieutri.ma_thuoc = thuoc.maThuoc
                    WHERE bn_noitru.maBenhNhan = '$maBenhNhan'
                    GROUP BY bn_noitru.maBenhNhan";

                $result_total_cost = mysqli_query($con, $sql_total_cost);
                $row_total_cost = mysqli_fetch_assoc($result_total_cost);
                $totalCost = $row_total_cost['totalCost'] ?: 0;
                $tenThuocList = $row_total_cost['tenThuocList'] ?: "Không có thuốc";

                // Cập nhật chi phí vào bảng bn_noitru
                $update_sql = "
                    UPDATE bn_noitru 
                    SET chiPhi = '$totalCost' 
                    WHERE maBenhNhan = '$maBenhNhan'";
                mysqli_query($con, $update_sql);

                // Hiển thị thông tin bệnh nhân nội trú
                echo "<tr>";
                echo "<td>{$hoTen}</td>";
                echo "<td>{$loaiBenhNhan}</td>";
                echo "<td>{$totalCost}</td>";
                echo "<td>{$tenThuocList}</td>";
                echo "</tr>";
            } elseif ($loaiBenhNhan == "Ngoại Trú") {
                // Truy vấn thông tin và tổng chi phí cho bệnh nhân ngoại trú
                $sql_total_cost = "
                    SELECT SUM(chiPhi) AS totalCost, 
                           GROUP_CONCAT(thuoc SEPARATOR ', ') AS tenThuocList
                    FROM bn_ngoaitru
                    WHERE maBenhNhan = '$maBenhNhan'
                    GROUP BY maBenhNhan";

                $result_total_cost = mysqli_query($con, $sql_total_cost);
                $row_total_cost = mysqli_fetch_assoc($result_total_cost);
                $totalCost = $row_total_cost['totalCost'] ?: 0;
                $tenThuocList = $row_total_cost['tenThuocList'] ?: "Không có thuốc";

                // Thêm phí khám mặc định 30.000
                $phiKham = 30000;
                $totalCost += $phiKham;

                // Cập nhật chi phí vào bảng bn_ngoaitru
                $update_sql = "
                    UPDATE bn_ngoaitru 
                    SET chiPhi = '$totalCost' 
                    WHERE maBenhNhan = '$maBenhNhan'";
                mysqli_query($con, $update_sql);

                // Hiển thị thông tin bệnh nhân ngoại trú
                echo "<tr>";
                echo "<td>{$hoTen}</td>";
                echo "<td>{$loaiBenhNhan}</td>";
                echo "<td>{$totalCost}</td>";
                echo "<td>{$phiKham}</td>"; // Hiển thị phí khám
                echo "<td>{$tenThuocList}</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    } else {
        // Không tìm thấy bệnh nhân
        echo "<p>Không tìm thấy bệnh nhân với số điện thoại này.</p>";
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