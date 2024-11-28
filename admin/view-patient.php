<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Doctor | Manage Patients</title>

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
  <link href="../assets/css/custom.css" rel="stylesheet">
  <body class="nav-md">
    <?php
    $page_title = 'Doctor | Quản Lý Bệnh Nhân';
    $x_content = true;
    ?>
    <?php include('include/header.php');?>

    <div class="row">
   <div class="col-md-12">
      <h5 class="over-title margin-bottom-15">Quản Lý <span class="text-bold">Bệnh Nhân</span></h5>
      <?php
      // Lấy mã bác sĩ từ URL
      $vid = $_GET['viewid'];

      // Truy vấn tất cả bệnh nhân được bác sĩ với maBacSi = $vid khám
      $ret = mysqli_query($con, "SELECT b.maBenhNhan, b.hoTen, b.soDienThoai, b.diaChi, b.gioiTinh, b.ngaySinh, b.LoaiBenhNhan
                                  FROM benhnhan b
                                  JOIN dieutri d ON b.maBenhNhan = d.maBenhNhan
                                  WHERE d.maBacSi = '$vid'");
      
      // Kiểm tra xem truy vấn có thành công không
      if (!$ret) {
          // Nếu truy vấn không thành công, in ra lỗi
          echo "Lỗi truy vấn: " . mysqli_error($con);
      } else {
          // Nếu truy vấn thành công, hiển thị kết quả
          $cnt = 1;

          // Lặp qua các bệnh nhân và hiển thị thông tin
          while ($row = mysqli_fetch_array($ret)) {
      ?>
      <table border="1" class="table table-bordered">
         <tr align="center">
            <td colspan="4" style="font-size:20px;color:blue">
               Chi tiết bệnh nhân
            </td>
         </tr>

         <tr>
            <th scope>Họ Tên</th>
            <td><?php echo $row['hoTen']; ?></td>
            <th scope>Loại Khám</th>
            <td><?php echo $row['LoaiBenhNhan']; ?></td>
         </tr>
         <tr>
            <th scope>Số Điện Thoại</th>
            <td><?php echo $row['soDienThoai']; ?></td>
            <th>Địa Chỉ</th>
            <td><?php echo $row['diaChi']; ?></td>
         </tr>
         <tr>
            <th>Giới Tính</th>
            <td><?php echo $row['gioiTinh']; ?></td>
            <th>Ngày Sinh</th>
            <td><?php echo $row['ngaySinh']; ?></td>
         </tr>

      <?php 
          }
      }
      ?>
      </table>
   </div>
</div>


</div>
</div>

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