<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {

    // Lấy các giá trị từ form
    $hoTen = $_POST['HoTen'];
    $ngaySinh = $_POST['NgaySinh'];
    $gioiTinh = $_POST['GioiTinh'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];
    $loaiBenhNhan = $_POST['LoaiBenhNhan'];  // Nội hoặc ngoại

    // Thực thi câu lệnh SQL để thêm bệnh nhân mới vào bảng benhnhan
    $sql = mysqli_query($con, "INSERT INTO benhnhan (HoTen, NgaySinh, GioiTinh, DiaChi, SoDienThoai, LoaiBenhNhan) 
                              VALUES ('$hoTen', '$ngaySinh', '$gioiTinh', '$diaChi', '$soDienThoai',  '$loaiBenhNhan')");

    // Kiểm tra nếu thêm thành công
    if ($sql) {
        // Lấy ID của bệnh nhân vừa thêm
        $last_insert_id = mysqli_insert_id($con);

        // Nếu bệnh nhân là ngoại trú, tạo mã bệnh nhân ngoại trú
        if ($loaiBenhNhan == 'Ngoại Trú') {
            // Tạo mã bệnh nhân ngoại trú
            $maBenhAnNgoaiTru = 'OP' . str_pad($last_insert_id, 9, '0', STR_PAD_LEFT);

            // Thêm thông tin vào bảng bn_ngoaitru
            $sql_bn_ngoaitru = mysqli_query($con, "INSERT INTO bn_ngoaitru (maBenhAnNgoaiTru, maBenhNhan) 
                                                    VALUES ('$maBenhAnNgoaiTru', '$last_insert_id')");
        }

        // Nếu bệnh nhân là nội trú, tạo mã bệnh nhân nội trú
        if ($loaiBenhNhan == 'Nội Trú') {
            // Tạo mã bệnh nhân nội trú
            $maBenhAnNoiTru = 'IP' . str_pad($last_insert_id, 9, '0', STR_PAD_LEFT);

            // Thêm thông tin vào bảng bn_noitru
            $sql_bn_noitru = mysqli_query($con, "INSERT INTO bn_noitru (maBenhAnNoiTru, maBenhNhan) 
                                                  VALUES ('$maBenhAnNoiTru', '$last_insert_id')");
        }

        // Hiển thị thông báo và chuyển hướng
        echo "<script>alert('Đăng ký bệnh nhân thành công!'); window.location.href='add-patient.php';</script>";
    } else {
        // In ra lỗi nếu có
        $error_message = mysqli_error($con);
        echo "<script>alert('Có lỗi xảy ra trong quá trình đăng ký: $error_message');</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Doctor | Add Patient</title>

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
				data: 'email=' + $("#patemail").val(),
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
	<?php
	$page_title = 'Patient | Add Patient';
	$x_content = true;
	?>
	<?php include('include/header.php'); ?>

	<div class="row">
		<div class="col-md-12">
			<div class="row margin-top-30">
				<div class="col-lg-8 col-md-12">

					<div class="panel panel-white">
    <div class="panel-heading">
        <h5 class="panel-title">Thêm Bệnh Nhân</h5>
    </div>
    <div class="panel-body">
	<?php
// Kết nối cơ sở dữ liệu
include('include/config.php');
// Truy vấn danh sách bác sĩ
$sql = "SELECT maNV, hoTen, chuyenNganh FROM nhanvien WHERE loaiNhanVien = 'Bác sĩ'";
$result = mysqli_query($con, $sql);
?>
<form role="form" method="post">

<div class="form-group">
	<label for="HoTen">Tên Bệnh Nhân</label>
	<input type="text" name="HoTen" class="form-control" placeholder="Tên Bệnh Nhân" required="true">
</div>

<div class="form-group">
	<label for="NgaySinh">Ngày Sinh</label>
	<input type="date" name="NgaySinh" class="form-control" required="true">
</div>

<div class="form-group">
	<label for="GioiTinh">Giới Tính</label>
	<div class="clip-radio radio-primary">
		<input type="radio" id="rg-female" name="GioiTinh" value="Nữ">
		<label for="rg-female">Nữ</label>
		<input type="radio" id="rg-male" name="GioiTinh" value="Nam">
		<label for="rg-male">Nam</label>
	</div>
</div>

<div class="form-group">
	<label for="DiaChi">Địa chỉ bệnh nhân</label>
	<textarea name="DiaChi" class="form-control" placeholder="Địa chỉ bệnh nhân" required="true"></textarea>
</div>

<div class="form-group">
	<label for="SoDienThoai">Số Điện Thoại</label>
	<input type="text" name="SoDienThoai" class="form-control" placeholder="Số Điện Thoại" required="true" maxlength="10" pattern="[0-9]+">
</div>


<!-- Thêm phần chọn loại bệnh nhân -->
<div class="form-group">
	<label for="LoaiBenhNhan">Loại Bệnh Nhân</label>
	<select name="LoaiBenhNhan" class="form-control" required="true">
		<option value="Ngoại Trú">Ngoại Trú</option>
		<option value="Nội Trú">Nội Trú</option>
	</select>
</div>


<button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
	Thêm
</button>
</form>

<?php
// Đóng kết nối
mysqli_close($con);
?>

    </div>
</div>

				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-white">
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