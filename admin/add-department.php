<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();


$sqlBacSi = "SELECT maNV, hoTen, chuyenNganh FROM nhanvien WHERE loaiNhanVien = 'Bác sĩ'";
$resultBacSi = mysqli_query($con, $sqlBacSi);
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form và kiểm tra xem dữ liệu có hợp lệ không
    $maKhoa = $_POST['maKhoa'];
    $tieuDe = $_POST['tieuDe'];
    $maBacSi = $_POST['maBacSi'];  // Mã bác sĩ từ dropdown

    // Kiểm tra xem mã bác sĩ có được nhập hay không
    if (empty($maBacSi)) {
        echo "<script>alert('Vui lòng chọn mã bác sĩ');</script>";
    } else {
        // Kiểm tra xem mã bác sĩ và năm nhận bằng
        $sqlBacSi = "SELECT namNhanBang FROM nhanvien WHERE maNV = '$maBacSi' AND loaiNhanVien = 'Bác sĩ'";

        $resultBacSi = mysqli_query($con, $sqlBacSi);

        if (mysqli_num_rows($resultBacSi) > 0) {
            $row = mysqli_fetch_assoc($resultBacSi);
            $namNhanBang = $row['namNhanBang'];

            // Kiểm tra năm nhận bằng của bác sĩ
            if (2024 - $namNhanBang > 5) {
                // Nếu năm nhận bằng > 5, thêm thông tin khoa mới vào cơ sở dữ liệu
                $sqlKhoa = "INSERT INTO khoa (maKhoa, tieuDe, truongKhoa) VALUES ('$maKhoa', '$tieuDe', '$maBacSi')";

                $sqlResult = mysqli_query($con, $sqlKhoa);

                if ($sqlResult) {
                    echo "<script>alert('Khoa và trưởng khoa đã được thêm thành công');</script>";
                } else {
                    // Hiển thị thông báo lỗi SQL chi tiết
                    echo "<script>alert('Lỗi khi thêm khoa vào cơ sở dữ liệu: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Trưởng khoa (bác sĩ) phải có năm nhận bằng lớn hơn 5 năm');</script>";
            }
        } else {
            echo "<script>alert('Không tìm thấy bác sĩ với mã bác sĩ');</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin | Thêm Bác Sĩ</title>

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

						<form role="form" name="addDepartment" method="post">
    <!-- Thông tin khoa -->
    <div class="form-group">
        <label for="maKhoa">Mã Khoa</label>
        <input type="text" name="maKhoa" class="form-control" placeholder="Nhập mã khoa" required="true">
    </div>

    <div class="form-group">
        <label for="tieuDe">Tiêu Đề</label>
        <input type="text" name="tieuDe" class="form-control" placeholder="Nhập tiêu đề" required="true">
    </div>

    <!-- Dropdown chọn bác sĩ -->
    <div class="form-group">
        <label for="maBacSi">Trưởng Khoa</label>
        <select name="maBacSi" class="form-control" required="true">
            <option value="">Chọn Trưởng Khoa (Bác sĩ)</option>
            <?php
            if (mysqli_num_rows($resultBacSi) > 0) {
                while ($row = mysqli_fetch_assoc($resultBacSi)) {
                    echo "<option value='" . $row['maNV'] . "'>" . $row['hoTen'] . " - " . $row['chuyenNganh'] . "</option>";
                }
            } else {
                echo "<option value=''>Không có bác sĩ</option>";
            }
            ?>
        </select>
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
