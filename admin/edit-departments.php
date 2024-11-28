<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();





// Kết nối cơ sở dữ liệu
include('config.php'); // File kết nối database

// Kiểm tra xem có mã khoa được truyền vào không (cho trường hợp edit)
if (isset($_GET['maKhoa'])) {
    $maKhoa = $_GET['maKhoa'];

    // Lấy thông tin khoa hiện tại từ cơ sở dữ liệu
    $sqlKhoa = "SELECT * FROM khoa WHERE maKhoa = '$maKhoa'";
    $resultKhoa = mysqli_query($con, $sqlKhoa);
    
    if (mysqli_num_rows($resultKhoa) > 0) {
        $rowKhoa = mysqli_fetch_assoc($resultKhoa);
        $maKhoa = $rowKhoa['maKhoa'];
        $tieuDe = $rowKhoa['tieuDe'];
        $maBacSi = $rowKhoa['truongKhoa'];
    } else {
        echo "<script>alert('Không tìm thấy khoa');</script>";
    }
}

// Kiểm tra khi người dùng gửi form sửa
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form
    $maKhoa = $_POST['maKhoa'];
    $tieuDe = $_POST['tieuDe'];
    $maBacSi = $_POST['maBacSi'];  // Mã bác sĩ

    // Kiểm tra xem mã bác sĩ có được nhập hay không
    if (empty($maBacSi)) {
        echo "<script>alert('Vui lòng nhập mã bác sĩ');</script>";
    } else {
        // Kiểm tra xem mã bác sĩ có tồn tại không
        $sqlBacSi = "SELECT namNhanBang FROM nhanvien WHERE maNV = '$maBacSi' AND loaiNhanVien = 'Bác sĩ'";
        $resultBacSi = mysqli_query($con, $sqlBacSi);

        if (mysqli_num_rows($resultBacSi) > 0) {
            $row = mysqli_fetch_assoc($resultBacSi);
            $namNhanBang = $row['namNhanBang'];

            // Kiểm tra năm nhận bằng của bác sĩ
            if (2024 - $namNhanBang > 5) {
                // Nếu năm nhận bằng > 5, cập nhật thông tin khoa vào cơ sở dữ liệu
                $sqlUpdate = "UPDATE khoa SET tieuDe = '$tieuDe', truongKhoa = '$maBacSi' WHERE maKhoa = '$maKhoa'";

                // Thực thi câu truy vấn
                $sqlResult = mysqli_query($con, $sqlUpdate);

                if ($sqlResult) {
                    echo "<script>alert('Thông tin khoa đã được cập nhật thành công');</script>";
                } else {
                    echo "<script>alert('Lỗi khi cập nhật thông tin khoa: " . mysqli_error($con) . "');</script>";
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

                        <form role="form" name="editDepartment" method="post">
    <!-- Thông tin khoa -->
    <div class="form-group">
        <label for="maKhoa">Mã Khoa</label>
        <input type="text" name="maKhoa" class="form-control" placeholder="Nhập mã khoa" required="true" value="<?php echo $maKhoa; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="tieuDe">Tiêu Đề</label>
        <input type="text" name="tieuDe" class="form-control" placeholder="Nhập tiêu đề" required="true" value="<?php echo $tieuDe; ?>">
    </div>

    <div class="form-group">
        <label for="maBacSi">Trưởng Khoa (nhập mã)</label>
        <input type="text" name="maBacSi" class="form-control" placeholder="Nhập mã bác sĩ" required="true" value="<?php echo $maBacSi; ?>">
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
