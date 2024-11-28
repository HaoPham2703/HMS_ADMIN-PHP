<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Lấy giá trị ID từ URL
$tid = isset($_GET['editid']) ? intval($_GET['editid']) : 0; // Lấy giá trị 'editid' từ URL và chuyển sang số nguyên



// Nếu có yêu cầu cập nhật thông tin
if (isset($_POST['submit'])) {
    $tenThuoc = $_POST['tenThuoc'];
    $congDung = $_POST['congDung'];
    $giaCa = $_POST['giaCa'];
    $ngayHetHan = $_POST['ngayHetHan'];

    // Cập nhật thông tin thuốc trong cơ sở dữ liệu
    $sql = mysqli_query($con, "UPDATE thuoc SET tenThuoc='$tenThuoc', congDung='$congDung', giaCa='$giaCa', ngayHetHan='$ngayHetHan' WHERE maThuoc='$tid'");

    if ($sql) {
        $msg = "Thông tin thuốc đã được cập nhật thành công.";
    } else {
        $msg = "Có lỗi khi cập nhật thông tin thuốc.";
    }
}

// Truy vấn dữ liệu thuốc từ cơ sở dữ liệu
$sql = mysqli_query($con, "SELECT * FROM thuoc WHERE maThuoc='$tid'");
if (mysqli_num_rows($sql) == 0) {
    echo "Không tìm thấy thuốc với ID này.";
    exit; // Dừng chương trình nếu không tìm thấy thuốc với ID này
}

$data = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Chỉnh sửa thông tin thuốc</title>

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
    $page_title = 'Admin | Edit Thuoc Details';
    $x_content = true;
    ?>
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
                            <h5 class="panel-title">Chỉnh sửa thông tin thuốc</h5>
                        </div>
                        <div class="panel-body">
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM thuoc WHERE maThuoc='$tid'");
                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <h4><?php echo htmlentities($data['tenThuoc']); ?>'s Profile</h4>
                                <p><b>Ngày nhập thuốc: </b><?php echo htmlentities($data['ngayNhap']); ?></p>
                                <p><b>Ngày hết hạn: </b><?php echo htmlentities($data['ngayHetHan']); ?></p>
                                <hr />
                                <form role="form" name="editthuoc" method="post" onSubmit="return valid();">
                                    <div class="form-group">
                                        <label for="tenThuoc">Tên Thuốc</label>
                                        <input type="text" name="tenThuoc" class="form-control" value="<?php echo htmlentities($data['tenThuoc']); ?>" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="congDung">Công Dụng</label>
                                        <textarea name="congDung" class="form-control" required="required"><?php echo htmlentities($data['congDung']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="giaCa">Giá Thuốc</label>
                                        <input type="text" name="giaCa" class="form-control" required="required" value="<?php echo htmlentities($data['giaCa']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="ngayHetHan">Ngày Hết Hạn</label>
                                        <input type="date" name="ngayHetHan" class="form-control" required="required" value="<?php echo htmlentities($data['ngayHetHan']); ?>">
                                    </div>

                                <?php } ?>
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