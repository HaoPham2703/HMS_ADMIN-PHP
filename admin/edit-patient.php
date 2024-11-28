<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

$id = $_GET['id'];

// Truy vấn thông tin bệnh nhân từ bảng benhnhan
$query = "SELECT * FROM benhnhan WHERE maBenhNhan = '$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

if (isset($_POST['update'])) {
    // Lấy dữ liệu từ form
    $hoTen = $_POST['HoTen'];
    $ngaySinh = $_POST['NgaySinh'];
  
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];

    // Cập nhật thông tin vào cơ sở dữ liệu
    $updateQuery = "UPDATE benhnhan 
                    SET hoTen = '$hoTen', 
                        ngaySinh = '$ngaySinh', 
                     
                        diaChi = '$diaChi', 
                        soDienThoai = '$soDienThoai' 
                    WHERE maBenhNhan = '$id'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='manage-patient.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
	<link href="../assets/css/custom.css" rel="stylesheet">

	<script>
        function userAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
				data: 'email=' + $("#Email").val(),
				type: "POST",
				success: function(data) {
					$("#user-availability-status1").html(data);
					$("#loaderIcon").hide();
				},
				error: function() {}
			});
		}
	</script>
</head>
<body class="nav-md">
    <?php include('include/header.php'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="row margin-top-30">
                <div class="col-lg-8 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">Sửa Thông Tin Bệnh Nhân</h5>
                        </div>
                        <div class="panel-body">
                        <form role="form" method="post">
    <!-- Input Tên Bệnh Nhân -->
    <div class="form-group">
        <label for="HoTen">Tên Bệnh Nhân</label>
        <input type="text" name="HoTen" class="form-control" placeholder="Tên Bệnh Nhân" required="true" value="<?php echo $row['hoTen']; ?>">
    </div>

    <!-- Input Ngày Sinh -->
    <div class="form-group">
        <label for="NgaySinh">Ngày Sinh</label>
        <input type="date" name="NgaySinh" class="form-control" required="true" value="<?php echo $row['ngaySinh']; ?>">
    </div>

  

    <!-- Input Địa Chỉ -->
    <div class="form-group">
        <label for="DiaChi">Địa chỉ bệnh nhân</label>
        <textarea name="DiaChi" class="form-control" placeholder="Địa chỉ bệnh nhân" required="true"><?php echo $row['diaChi']; ?></textarea>
    </div>

    <!-- Input Số Điện Thoại -->
    <div class="form-group">
        <label for="SoDienThoai">Số Điện Thoại</label>
        <input type="text" name="SoDienThoai" class="form-control" placeholder="Số Điện Thoại" required="true" maxlength="10" pattern="[0-9]+" value="<?php echo $row['soDienThoai']; ?>">
    </div>

    <!-- Nút Submit -->
    <button type="submit" name="update" id="update" class="btn btn-o btn-primary">
        Cập nhật
    </button>
</form>

                        </div>
                    </div>
                </div>
            </div>
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
</html>
