<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Lấy giá trị ID từ URL
$nid = isset($_GET['editid']) ? intval($_GET['editid']) : 0; // Lấy giá trị 'editid' từ URL và chuyển sang số nguyên



// Nếu có yêu cầu cập nhật thông tin
if (isset($_POST['submit'])) {
    $tenNhaCungCap = $_POST['tenNhaCungCap'];
    $diaChi = $_POST['diaChi'];
    $soDienThoai = $_POST['soDienThoai'];

    // Cập nhật thông tin nhà cung cấp trong cơ sở dữ liệu
    $sql = mysqli_query($con, "UPDATE nhacungcap SET tenNhaCungCap='$tenNhaCungCap', diaChi='$diaChi', soDienThoai='$soDienThoai' WHERE maNhaCungCap='$nid'");

    if ($sql) {
        $msg = "Thông tin nhà cung cấp đã được cập nhật thành công.";
    } else {
        $msg = "Có lỗi khi cập nhật thông tin nhà cung cấp.";
    }
}

// Truy vấn dữ liệu nhà cung cấp từ cơ sở dữ liệu
$sql = mysqli_query($con, "SELECT * FROM nhacungcap WHERE maNhaCungCap='$nid'");
if (mysqli_num_rows($sql) == 0) {
    echo "Không tìm thấy nhà cung cấp với ID này.";
    exit; // Dừng chương trình nếu không tìm thấy nhà cung cấp với ID này
}

$data = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Chỉnh sửa nhà cung cấp</title>

    <!-- Các thư viện CSS -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../assets/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php include('include/header.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <h5 style="color: green; font-size:18px;">
                <?php if ($msg) {
                    echo htmlentities($msg);
                } ?> </h5>
            <div class="row margin-top-30">
                <div class="col-lg-8 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">Chỉnh sửa thông tin nhà cung cấp</h5>
                        </div>
                        <div class="panel-body">
                            <h4><?php echo htmlentities($data['tenNhaCungCap']); ?>'s Profile</h4>
                            <p><b>Địa chỉ: </b><?php echo htmlentities($data['diaChi']); ?></p>
                            <p><b>Số điện thoại: </b><?php echo htmlentities($data['soDienThoai']); ?></p>
                            <hr />
                            <form role="form" name="editnhacungcap" method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <label for="tenNhaCungCap">Tên Nhà Cung Cấp</label>
                                    <input type="text" name="tenNhaCungCap" class="form-control" value="<?php echo htmlentities($data['tenNhaCungCap']); ?>" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="diaChi">Địa Chỉ</label>
                                    <textarea name="diaChi" class="form-control" required="required"><?php echo htmlentities($data['diaChi']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="soDienThoai">Số Điện Thoại</label>
                                    <input type="text" name="soDienThoai" class="form-control" required="required" value="<?php echo htmlentities($data['soDienThoai']); ?>">
                                </div>

                                <button type="submit" name="submit" class="btn btn-o btn-primary">
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
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <script src="../vendors/skycons/skycons.js"></script>
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <script src="../vendors/DateJS/build/date.js"></script>
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../assets/js/custom.min.js"></script>
</body>

</html>