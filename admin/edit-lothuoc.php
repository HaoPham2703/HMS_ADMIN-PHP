<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Lấy ID lô thuốc từ URL
$loThuocId = intval($_GET['editid']); // Dùng 'editid' từ URL để lấy ID lô thuốc

// Kiểm tra nếu có form được gửi đi
if (isset($_POST['submit'])) {
    // Lấy các giá trị từ form
    $maThuoc = $_POST['maThuoc'];
    $maNhaCungCap = $_POST['maNhaCungCap'];
    $ngayNhap = $_POST['ngayNhap'];
    $soLuong = $_POST['soLuong'];
    $giaNhap = $_POST['giaNhap'];

    // Cập nhật thông tin lô thuốc
    $sql = mysqli_query($con, "UPDATE lothuoc SET maThuoc='$maThuoc', maNhaCungCap='$maNhaCungCap', ngayNhap='$ngayNhap', soLuong='$soLuong', giaNhap='$giaNhap' WHERE maLoThuoc='$loThuocId'");

    if ($sql) {
        $msg = "Lô thuốc đã được cập nhật thành công";
    }
}

// Lấy thông tin lô thuốc hiện tại
$sql = mysqli_query($con, "SELECT * FROM lothuoc WHERE maLoThuoc='$loThuocId'");
$data = mysqli_fetch_array($sql);

// Lấy tên thuốc dựa trên maThuoc của lô thuốc
$maThuoc = $data['maThuoc'];
$sqlThuoc = mysqli_query($con, "SELECT tenThuoc FROM thuoc WHERE maThuoc='$maThuoc'");
$dataThuoc = mysqli_fetch_array($sqlThuoc);
$tenThuoc = $dataThuoc['tenThuoc'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Edit Lô Thuốc</title>
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
            <h5 style="color: green; font-size:18px;">
                <?php if ($msg) {
                    echo htmlentities($msg);
                } ?>
            </h5>
            <div class="row margin-top-30">
                <div class="col-lg-8 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">Edit Lô Thuốc</h5>
                        </div>
                        <div class="panel-body">
                            <h4>Cập nhật thông tin cho lô thuốc: <?php echo htmlentities($tenThuoc); ?></h4>
                            <p><b>Ngày nhập:</b> <?php echo htmlentities($data['ngayNhap']); ?></p>

                            <form role="form" name="editlotthuoc" method="post">
                                <div class="form-group">
                                    <label for="maThuoc">Tên Thuốc</label>
                                    <select name="maThuoc" class="form-control" required="required">
                                        <option value="<?php echo htmlentities($data['maThuoc']); ?>">
                                            <?php echo htmlentities($tenThuoc); ?>
                                        </option>
                                        <?php
                                        // Lấy danh sách thuốc
                                        $ret = mysqli_query($con, "SELECT * FROM thuoc");
                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo htmlentities($row['maThuoc']); ?>">
                                                <?php echo htmlentities($row['tenThuoc']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="maNhaCungCap">Nhà Cung Cấp</label>
                                    <select name="maNhaCungCap" class="form-control" required="required">
                                        <option value="<?php echo htmlentities($data['maNhaCungCap']); ?>">
                                            <?php echo htmlentities($data['maNhaCungCap']); ?>
                                        </option>
                                        <?php
                                        // Lấy danh sách nhà cung cấp
                                        $ret = mysqli_query($con, "SELECT * FROM nhacungcap");
                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo htmlentities($row['maNhaCungCap']); ?>">
                                                <?php echo htmlentities($row['tenNhaCungCap']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="ngayNhap">Ngày Nhập</label>
                                    <input type="date" name="ngayNhap" class="form-control" value="<?php echo htmlentities($data['ngayNhap']); ?>" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="soLuong">Số Lượng</label>
                                    <input type="number" name="soLuong" class="form-control" value="<?php echo htmlentities($data['soLuong']); ?>" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="giaNhap">Giá Nhập</label>
                                    <input type="text" name="giaNhap" class="form-control" value="<?php echo htmlentities($data['giaNhap']); ?>" required="required">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
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
    <!-- Custom Theme Scripts -->
    <script src="../assets/js/custom.min.js"></script>
</body>

</html>