<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();





if (isset($_POST['submit'])) {
    // Lấy thông tin từ form (không cần lấy maNV nữa vì đã tự động tăng)
    $hoTen = $_POST['hoTen'];
    $ngaySinh = $_POST['ngaySinh'];
    $gioiTinh = $_POST['gioiTinh'];
    $diaChi = $_POST['diaChi'];
    $ngayBatDauLam = $_POST['ngayBatDauLam'];
    $soDienThoai = $_POST['soDienThoai'];
    $chuyenNganh = $_POST['chuyenNganh'];
    $namNhanBang = $_POST['namNhanBang'];
    $loaiNhanVien = $_POST['loaiNhanVien'];
    $maKhoa = $_POST['maKhoa'];
	$loaiNhanVien = 'Y tá';

    // Tắt kiểm tra khóa ngoại tạm thời
    $sql_disable_fk = "SET foreign_key_checks = 0;";
    mysqli_query($con, $sql_disable_fk); // Thực hiện câu lệnh tắt kiểm tra khóa ngoại

    // Kết nối cơ sở dữ liệu và thêm thông tin vào bảng nhân viên
    $sql = mysqli_query($con, "INSERT INTO nhanvien(hoTen, ngaySinh, gioiTinh, diaChi, ngayBatDauLam, soDienThoai, chuyenNganh, namNhanBang, loaiNhanVien, maKhoa) 
                               VALUES ('$hoTen', '$ngaySinh', '$gioiTinh', '$diaChi', '$ngayBatDauLam', '$soDienThoai', '$chuyenNganh', '$namNhanBang', '$loaiNhanVien', '$maKhoa')");

    if ($sql) {
        echo "<script>alert('Thông tin nhân viên được thêm thành công');</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm nhân viên');</script>";
    }

    // Bật lại kiểm tra khóa ngoại
    $sql_enable_fk = "SET foreign_key_checks = 1;";
    mysqli_query($con, $sql_enable_fk); // Thực hiện câu lệnh bật lại kiểm tra khóa ngoại
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin | Thêm Y Tá</title>

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
	<script type="text/javascript">
		function valid()
		{
			if(document.adddoc.npass.value!= document.adddoc.cfpass.value)
			{
				alert("Password and Confirm Password Field do not match  !!");
				document.adddoc.cfpass.focus();
				return false;
			}
			return true;
		}
	</script>


	<script>
		function checkemailAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
				data:'emailid='+$("#docemail").val(),
				type: "POST",
				success:function(data){
					$("#email-availability-status").html(data);
					$("#loaderIcon").hide();
				},
				error:function (){}
			});
		}
	</script>
</head>
<body class="nav-md">
	<?php
	$page_title = 'Add Doctor';
	$x_content = true;
	?>
	<?php include('include/header.php');?>

	<div class="row">
		<div class="col-md-12">

			<div class="row margin-top-30">
				<div class="col-lg-8 col-md-12">
					<div class="panel panel-white">
						<div class="panel-body">

						<form role="form" name="addBacSi" method="post">
    <!-- Thông tin nhân viên chung -->
    <div class="form-group">
        <label for="hoTen">Họ và Tên</label>
        <input type="text" name="hoTen" class="form-control" placeholder="Nhập họ và tên" required="true">
    </div>

    <div class="form-group">
        <label for="ngaySinh">Ngày Sinh</label>
        <input type="date" name="ngaySinh" class="form-control" required="true">
    </div>

    <div class="form-group">
        <label for="gioiTinh">Giới Tính</label>
        <select name="gioiTinh" class="form-control" required="true">
            <option value="Nam">Nam</option>
            <option value="Nu">Nữ</option>
        </select>
    </div>

    <div class="form-group">
        <label for="diaChi">Địa Chỉ</label>
        <textarea name="diaChi" class="form-control" placeholder="Nhập địa chỉ" required="true"></textarea>
    </div>

    <div class="form-group">
        <label for="ngayBatDauLam">Ngày Bắt Đầu Làm</label>
        <input type="date" name="ngayBatDauLam" class="form-control" required="true">
    </div>

    <div class="form-group">
        <label for="soDienThoai">Số Điện Thoại</label>
        <input type="text" name="soDienThoai" class="form-control" placeholder="Nhập số điện thoại" required="true">
    </div>

    <div class="form-group">
        <label for="chuyenNganh">Chuyên Ngành</label>
        <input type="text" name="chuyenNganh" class="form-control" placeholder="Nhập chuyên ngành" required="true">
    </div>

    <div class="form-group">
        <label for="namNhanBang">Năm Nhận Bằng</label>
        <input type="text" name="namNhanBang" class="form-control" placeholder="Nhập năm nhận bằng" required="true">
    </div>

    <!-- Thông tin riêng cho bác sĩ -->
    <div class="form-group">
        <label for="lamViec">Phòng trực</label>
        <input type="text" name="lamViec" class="form-control" placeholder="Nhập phòng trực" required="true">
    </div>
	<div class="form-group">
        <label for="maKhoa">Nhập mã khoa</label>
        <input type="text" name="maKhoa" class="form-control" placeholder="Nhập mã khoa" required="true">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Xác Nhận</button>
</form>









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
	<!-- start: FOOTER -->
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
