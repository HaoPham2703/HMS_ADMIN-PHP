<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    // Nhận dữ liệu từ biểu mẫu
    $tenNhaCungCap = $_POST['TenNhaCungCap'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];

    // Thực thi câu lệnh SQL để thêm nhà cung cấp mới vào bảng nhacungcap
    $sql = mysqli_query($con, "INSERT INTO nhacungcap (tenNhaCungCap, diaChi, soDienThoai) 
                               VALUES ('$tenNhaCungCap', '$diaChi', '$soDienThoai')");

    // Kiểm tra kết quả
    if ($sql) {
        echo "<script>alert('Thêm nhà cung cấp thành công!'); window.location.href='add-ncc.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra trong quá trình thêm nhà cung cấp.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pharmacy | Add Supplier</title>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../assets/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php include('include/header.php'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="row margin-top-30">
                <div class="col-lg-8 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">Thêm Nhà Cung Cấp</h5>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label for="TenNhaCungCap">Tên Nhà Cung Cấp</label>
                                    <input type="text" name="TenNhaCungCap" class="form-control" placeholder="Tên Nhà Cung Cấp" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="DiaChi">Địa Chỉ</label>
                                    <textarea name="DiaChi" class="form-control" placeholder="Địa chỉ nhà cung cấp" required="true"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="SoDienThoai">Số Điện Thoại</label>
                                    <input type="text" name="SoDienThoai" class="form-control" placeholder="Số điện thoại liên hệ" required="true">
                                </div>

                                <button type="submit" name="submit" class="btn btn-o btn-primary">
                                    Thêm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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