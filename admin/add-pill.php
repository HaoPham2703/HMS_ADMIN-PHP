<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {

    $tenThuoc = $_POST['TenThuoc'];
    $congDung = $_POST['CongDung'];
    $giaCa = $_POST['GiaCa'];
    $ngayHetHan = $_POST['NgayHetHan'];
    $maNhaCungCap = $_POST['MaNhaCungCap'];
    $maLoThuoc = $_POST['MaLoThuoc'];

    // Thực thi câu lệnh SQL để thêm thuốc mới vào bảng thuoc
    $sql = mysqli_query($con, "INSERT INTO thuoc (tenThuoc, congDung, giaCa, ngayHetHan, maNhaCungCap, maLoThuoc) 
                              VALUES ('$tenThuoc', '$congDung', '$giaCa', '$ngayHetHan', '$maNhaCungCap', '$maLoThuoc')");

    // Kiểm tra kết quả
    if ($sql) {
        echo "<script>alert('Thêm thuốc thành công!'); window.location.href='add-pill.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra trong quá trình thêm thuốc.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pharmacy | Add Pill</title>
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
    <?php include('include/header.php'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="row margin-top-30">
                <div class="col-lg-8 col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">Thêm Thuốc</h5>
                        </div>
                        <div class="panel-body">
                            <?php
                            // Kết nối cơ sở dữ liệu
                            include('include/config.php');
                            // Truy vấn danh sách nhà cung cấp và lô thuốc
                            $sqlNCC = "SELECT * FROM nhacungcap";
                            $resultNCC = mysqli_query($con, $sqlNCC);
                            $sqlLoThuoc = "SELECT * FROM lothuoc";
                            $resultLoThuoc = mysqli_query($con, $sqlLoThuoc);
                            ?>
                            <form role="form" method="post">

                                <div class="form-group">
                                    <label for="TenThuoc">Tên Thuốc</label>
                                    <input type="text" name="TenThuoc" class="form-control" placeholder="Tên Thuốc" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="CongDung">Công Dụng</label>
                                    <textarea name="CongDung" class="form-control" placeholder="Công dụng của thuốc" required="true"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="GiaCa">Giá Cả</label>
                                    <input type="number" name="GiaCa" class="form-control" placeholder="Giá của thuốc" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="NgayHetHan">Ngày Hết Hạn</label>
                                    <input type="date" name="NgayHetHan" class="form-control" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="MaNhaCungCap">Chọn Nhà Cung Cấp</label>
                                    <select name="MaNhaCungCap" class="form-control" required="true">
                                        <option value="">-- Chọn Nhà Cung Cấp --</option>
                                        <?php
                                        if (mysqli_num_rows($resultNCC) > 0) {
                                            while ($row = mysqli_fetch_assoc($resultNCC)) {
                                                echo '<option value="' . $row['maNhaCungCap'] . '">' . $row['tenNhaCungCap'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Không có nhà cung cấp nào</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="MaLoThuoc">Chọn Lô Thuốc</label>
                                    <select name="MaLoThuoc" class="form-control" required="true">
                                        <option value="">-- Chọn Lô Thuốc --</option>
                                        <?php
                                        if (mysqli_num_rows($resultLoThuoc) > 0) {
                                            while ($row = mysqli_fetch_assoc($resultLoThuoc)) {
                                                echo '<option value="' . $row['maLoThuoc'] . '">' . $row['maLoThuoc'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Không có lô thuốc nào</option>';
                                        }
                                        ?>
                                    </select>
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