<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $maLoThuoc = $_POST['MaLoThuoc'];
    $maThuoc = $_POST['MaThuoc'];
    $maNhaCungCap = $_POST['MaNhaCungCap'];
    $ngayNhap = $_POST['NgayNhap'];
    $soLuong = $_POST['SoLuong'];
    $giaNhap = $_POST['GiaNhap'];

    // Thực thi câu lệnh SQL để thêm lô thuốc mới vào bảng lothuoc
    $sql = mysqli_query($con, "INSERT INTO lothuoc (maLoThuoc, maThuoc, maNhaCungCap, ngayNhap, soLuong, giaNhap) 
                               VALUES ('$maLoThuoc', '$maThuoc', '$maNhaCungCap', '$ngayNhap', '$soLuong', '$giaNhap')");

    // Kiểm tra kết quả
    if ($sql) {
        echo "<script>alert('Thêm lô thuốc thành công!'); window.location.href='add-lothuoc.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra trong quá trình thêm lô thuốc.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pharmacy | Add Batch</title>
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
                            <h5 class="panel-title">Thêm Lô Thuốc</h5>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label for="MaLoThuoc">Mã Lô Thuốc</label>
                                    <input type="number" name="MaLoThuoc" class="form-control" placeholder="Mã Lô Thuốc" required>
                                </div>

                                <div class="form-group">
                                    <label for="MaThuoc">Mã Thuốc</label>
                                    <input type="number" name="MaThuoc" class="form-control" placeholder="Mã Thuốc" required>
                                </div>

                                <div class="form-group">
                                    <label for="MaNhaCungCap">Mã Nhà Cung Cấp</label>
                                    <input type="number" name="MaNhaCungCap" class="form-control" placeholder="Mã Nhà Cung Cấp" required>
                                </div>

                                <div class="form-group">
                                    <label for="NgayNhap">Ngày Nhập</label>
                                    <input type="date" name="NgayNhap" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="SoLuong">Số Lượng</label>
                                    <input type="number" name="SoLuong" class="form-control" placeholder="Số Lượng" required>
                                </div>

                                <div class="form-group">
                                    <label for="GiaNhap">Giá Nhập</label>
                                    <input type="text" name="GiaNhap" class="form-control" placeholder="Giá Nhập" required>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
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