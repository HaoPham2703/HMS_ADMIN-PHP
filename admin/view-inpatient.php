<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Lấy thông tin mã bệnh nhân nội trú từ URL
if (isset($_GET['viewid'])) {
    // Lấy mã bệnh án nội trú từ URL
    $maBenhAnNoiTru = $_GET['viewid'];

    // Truy vấn thông tin bệnh nhân nội trú
    $query_patient = mysqli_query($con, "
        SELECT b.maBenhNhan, b.hoTen, b.ngaySinh, b.gioiTinh, b.soDienThoai, b.diaChi
        FROM bn_noitru nt
        INNER JOIN benhnhan b ON nt.maBenhNhan = b.maBenhNhan
        WHERE b.LoaiBenhNhan = 'Nội Trú' AND nt.maBenhAnNoiTru = '$maBenhAnNoiTru'
    ");

    $patient = mysqli_fetch_array($query_patient);

    // Kiểm tra nếu bệnh nhân được tìm thấy
    $maBenhNhan = $patient['maBenhNhan'];

    // Truy vấn thông tin nội trú
    $query_inpatient = mysqli_query($con, "
        SELECT ngayNhapVien, ngayXuatVien, phongBenh, chiPhi
        FROM bn_noitru
        WHERE maBenhAnNoiTru = '$maBenhAnNoiTru'
    ");
    $inpatient = mysqli_fetch_array($query_inpatient);

    // Truy vấn danh sách bác sĩ
    $query_doctors = mysqli_query($con, "
        SELECT maNV, hoTen
        FROM nhanvien
        WHERE loaiNhanVien = 'Bác Sĩ'
    ");

    // Truy vấn danh sách y tá
    $query_nurses = mysqli_query($con, "
        SELECT maNV, hoTen
        FROM nhanvien
        WHERE loaiNhanVien = 'Y Tá'
    ");

    // Truy vấn danh sách thuốc
    $query_medicine = mysqli_query($con, "
        SELECT maThuoc, tenThuoc
        FROM thuoc
    ");

    // Truy vấn thông tin điều trị
    $query_treatment = mysqli_query($con, "
        SELECT 
            dt.thoiGianBatDau, dt.thoiGianKetThuc, dt.ketQuaDieuTri, 
            dt.maBacSi, bs.hoTen AS bacSi, 
            dt.maYta, yt.hoTen AS yTa,
            dt.ma_thuoc, thuoc.tenThuoc
        FROM dieutri dt
        INNER JOIN nhanvien bs ON dt.maBacSi = bs.maNV
        INNER JOIN nhanvien yt ON dt.maYta = yt.maNV
        INNER JOIN thuoc ON dt.ma_thuoc = thuoc.mathuoc
        WHERE dt.maBenhNhan = '$maBenhNhan'
    ");
    
    $treatment = mysqli_fetch_array($query_treatment);
    $query_treatment = mysqli_query($con, "
    SELECT thoiGianBatDau, thoiGianKetThuc 
    FROM dieutri 
    WHERE maBenhNhan = '$maBenhNhan'
    LIMIT 1
");
$treatment = mysqli_fetch_array($query_treatment);

}

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
    $page_title = 'Doctor | Manage Patients';
    $x_content = true;
    ?>
    <?php include('include/header.php');?>

    <div class="row">
      <div class="col-md-12">
        <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
       
    <!-- Hiển thị thông tin bệnh nhân -->
    
    <!-- Form cập nhật bệnh án -->
 
      
    <div class="container">
        <!-- Hiển thị thông tin bệnh nhân -->
        <h3>Thông Tin Bệnh Nhân Nội Trú</h3>
        <table class="table table-bordered">
            <tr>
                <th>Họ Tên</th>
                <td><?php echo $patient['hoTen']; ?></td>
            </tr>
            <tr>
                <th>Ngày Sinh</th>
                <td><?php echo $patient['ngaySinh']; ?></td>
            </tr>
            <tr>
                <th>Giới Tính</th>
                <td><?php echo $patient['gioiTinh']; ?></td>
            </tr>
            <tr>
                <th>Số Điện Thoại</th>
                <td><?php echo $patient['soDienThoai']; ?></td>
            </tr>
            <tr>
                <th>Địa Chỉ</th>
                <td><?php echo $patient['diaChi']; ?></td>
            </tr>
        </table>

        

        <!-- Form cập nhật thông tin nội trú -->
        <h3>Cập Nhật Thông Tin Nội Trú</h3>
   
<form method="POST" action="update-inpatient.php">
    <input type="hidden" name="maBenhNhan" value="<?php echo $maBenhNhan; ?>">
    
    <div class="form-group">
        <label for="ngayNhapVien">Ngày Nhập Viện:</label>
        <input type="date" name="ngayNhapVien" class="form-control" value="<?php echo $inpatient['ngayNhapVien']; ?>">
    </div>

    <div class="form-group">
    <label for="ngayXuatVien">Ngày Xuất Viện:</label>
    <!-- Checkbox cho "Khỏi bệnh" -->
    <div>
        <label>
            <input type="checkbox" name="ngayXuatVienOption" value="1" onclick="setNgayXuatVien()"> Khỏi bệnh
        </label>
    </div>
    <!-- Input ẩn để lưu giá trị ngày xuất viện -->
    <input type="hidden" name="ngayXuatVien" id="ngayXuatVien" value="<?php echo $inpatient['ngayXuatVien']; ?>">
</div>


    <div class="form-group">
        <label for="phongBenh">Phòng Bệnh:</label>
        <input type="text" name="phongBenh" class="form-control" value="<?php echo $inpatient['phongBenh']; ?>">
    </div>

    <button type="submit" class="btn btn-primary">Cập Nhật</button>
</form>

<script>
    function setNgayXuatVien() {
        // Lấy ngày hiện tại
        var today = new Date();
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2); // Tháng bắt đầu từ 0
        var year = today.getFullYear();
        
        // Định dạng lại ngày theo kiểu yyyy-mm-dd
        var formattedDate = year + "-" + month + "-" + day;
        
        // Cập nhật giá trị ngày xuất viện vào input hidden
        document.getElementById('ngayXuatVien').value = formattedDate;
    }
</script>



      <!-- Form thêm chi tiết điều trị -->
<h3>Thêm Chi Tiết Điều Trị</h3>
<form method="POST" action="insert-dieutri.php">
    <input type="hidden" name="maBenhAnNoiTru" value="<?php echo $maBenhAnNoiTru; ?>">

    <div class="form-group">
        <label for="thoiGianBatDau">Thời Gian Bắt Đầu:</label>
        <input type="date" name="thoiGianBatDau" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="thoiGianKetThuc">Thời Gian Kết Thúc:</label>
        <input type="date" name="thoiGianKetThuc" class="form-control">
    </div>

    <div class="form-group">
        <label for="ketQuaDieuTri">Kết Quả Điều Trị:</label>
        <textarea name="ketQuaDieuTri" class="form-control"></textarea>

    </div>

    <div class="form-group">
    <label for="ma_thuoc">Thuốc:</label>
    <select name="ma_thuoc[]" class="form-control" multiple required>
        <?php while ($medicine = mysqli_fetch_array($query_medicine)) { ?>
            <option value="<?php echo $medicine['maThuoc']; ?>">
                <?php echo $medicine['tenThuoc']; ?>
            </option>
        <?php } ?>
    </select>
</div>


    <div class="form-group">
    <label for="maBacSi">Bác Sĩ:</label>
    <select name="maBacSi[]" class="form-control" multiple required>
        <?php while ($doctor = mysqli_fetch_array($query_doctors)) { ?>
            <option value="<?php echo $doctor['maNV']; ?>">
                <?php echo $doctor['hoTen']; ?>
            </option>
        <?php } ?>
    </select>
</div>


    <div class="form-group">
        <label for="maYTa">Y Tá:</label>
        <select name="maYTa" class="form-control">
            <?php while ($nurse = mysqli_fetch_array($query_nurses)) { ?>
                <option value="<?php echo $nurse['maNV']; ?>">
                    <?php echo $nurse['hoTen']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Thêm Điều Trị</button>
</form>



    </div>
           </div>
         </div>
       </div>
     </div>
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