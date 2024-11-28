<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $vid = $_GET['mathuoc'];  // Lấy tham số mathuoc từ URL
    $bp = $_POST['bp'];
    $bs = $_POST['bs'];
    $weight = $_POST['weight'];
    $temp = $_POST['temp'];
    $pres = $_POST['pres'];
    $query = mysqli_query($con, "INSERT INTO tblmedicalhistory (PatientID, BloodPressure, BloodSugar, Weight, Temperature, MedicalPres) VALUES ('$vid', '$bp', '$bs', '$weight', '$temp', '$pres')");

    if ($query) {
        echo '<script>alert("Medical history has been added.")</script>';
        echo "<script>window.location.href ='manage-patient.php'</script>";
    } else {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Medicine | Details</title>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../assets/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php
    $page_title = 'Medicine | Details';
    $x_content = true;
    ?>
    <?php include('include/header.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <h5 class="over-title margin-bottom-15">Medicine <span class="text-bold">Details</span></h5>
            <?php
            // Lấy tham số mathuoc từ URL
            $vid = $_GET['mathuoc'];
            $ret = mysqli_query($con, "
                SELECT 
                    thuoc.tenThuoc, thuoc.congDung, thuoc.giaCa, thuoc.ngayHetHan,
                    lothuoc.ngayNhap, lothuoc.soLuong, lothuoc.giaNhap,
                    nhacungcap.tenNhaCungCap
                FROM 
                    thuoc
                LEFT JOIN 
                    lothuoc ON thuoc.maThuoc = lothuoc.maThuoc
                LEFT JOIN 
                    nhacungcap ON lothuoc.maNhaCungCap = nhacungcap.maNhaCungCap
                WHERE 
                    thuoc.maThuoc = '$vid'
            ");

            if ($row = mysqli_fetch_array($ret)) {
            ?>
                <table border="1" class="table table-bordered">
                    <tr align="center">
                        <td colspan="4" style="font-size:20px;color:blue">Medicine Details</td>
                    </tr>
                    <tr>
                        <th>Tên Thuốc</th>
                        <td><?php echo $row['tenThuoc']; ?></td>
                        <th>Giá Cả</th>
                        <td><?php echo number_format($row['giaCa'], 0, ',', '.') . ' VNĐ'; ?></td>
                    </tr>
                    <tr>
                        <th>Giá Nhập</th>
                        <td><?php echo isset($row['giaNhap']) ? number_format($row['giaNhap'], 0, ',', '.') . ' VNĐ' : 'Chưa có'; ?></td>
                        <th>Ngày Hết Hạn</th>
                        <td><?php echo $row['ngayHetHan']; ?></td>
                    </tr>
                    <tr>
                        <th>Ngày Nhập</th>
                        <td><?php echo isset($row['ngayNhap']) ? $row['ngayNhap'] : 'Chưa có'; ?></td>
                        <th>Số Lượng</th>
                        <td><?php echo isset($row['soLuong']) ? $row['soLuong'] : '0'; ?></td>
                    </tr>
                    <tr>
                        <th>Nội Dung Thuốc</th>
                        <td><?php echo $row['congDung']; ?></td>
                        <th>Nhà Cung Cấp</th>
                        <td><?php echo isset($row['tenNhaCungCap']) ? $row['tenNhaCungCap'] : 'Chưa có'; ?></td>
                    </tr>
                </table>
            <?php
            } else {
                echo "<p style='color:red;'>No details found for the selected medicine.</p>";
            }
            ?>
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