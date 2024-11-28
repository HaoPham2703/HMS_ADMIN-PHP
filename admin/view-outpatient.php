<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');

if (isset($_POST['submit'])) {

    $vid = $_GET['viewid']; // Patient ID
    $thuoc = $_POST['thuoc'];
    $pres = $_POST['pres'];
    $sick = $_POST['sick'];
    $fee = $_POST['fee'];
    $ntk = $_POST['ntk']; // Ngày khám tiếp theo
    $doctorId = $_POST['dtid'];
    $ngayKham = $_POST['ngayKham']; // Lấy ngày khám từ form

    // Query to get the doctor's full name
    $doctorQuery = mysqli_query($con, "SELECT hoTen FROM nhanvien WHERE maNV = '$doctorId'");
    $doctorRow = mysqli_fetch_assoc($doctorQuery);
    $doctorName = $doctorRow['hoTen'];

    // Tính tổng giá các thuốc đã chọn
    $totalPrice = 0;
    $thuocNames = [];
    foreach ($thuoc as $maThuoc) {
        // Lấy tên thuốc và giá của thuốc
        $query = mysqli_query($con, "SELECT tenThuoc, giaCa FROM thuoc WHERE maThuoc = '$maThuoc'");
        $row = mysqli_fetch_assoc($query);
        $thuocNames[] = $row['tenThuoc']; // Lưu tên thuốc
        $totalPrice += $row['giaCa']; // Cộng dồn giá các thuốc
    }

    // Chuyển mảng thuốc thành chuỗi
    $pres = implode(", ", $thuocNames);

    // Tổng phí khám = tổng giá thuốc + phí khám
    $totalFee = $totalPrice + $fee;

    // Kiểm tra xem bản ghi đã tồn tại hay chưa
    $checkQuery = mysqli_query($con, "SELECT * FROM bn_ngoaitru WHERE maBenhNhan = '$vid'");
    if (mysqli_num_rows($checkQuery) > 0) {
        // Nếu tồn tại, cập nhật bản ghi
        $updateQuery = "
        UPDATE bn_ngoaitru 
        SET ngayKham = '$ngayKham',
            chanDoan = '$sick', 
            thuoc = '$pres', 
            chiPhi = '$totalFee', 
            ngayKhamTiepTheo = '$ntk', 
            MaBacSi = '$doctorId', 
            TenBacSi = '$doctorName' 
        WHERE maBenhNhan = '$vid'
    ";
    
        if (mysqli_query($con, $updateQuery)) {
            echo '<script>alert("Medical history has been updated successfully.")</script>';
            echo "<script>window.location.href ='patient-outpatients.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again.")</script>';
        }
    } else {
        echo '<script>alert("No existing record found for the patient.")</script>';
    }
}

// Query to calculate total fee for display
$sumQuery = mysqli_query($con, "SELECT SUM(chiPhi) AS totalFee FROM bn_ngoaitru WHERE maBenhNhan = '$vid'");
if ($sumQuery) {
    $sumRow = mysqli_fetch_assoc($sumQuery);
    $totalFee = $sumRow['totalFee'];
} else {
    $totalFee = 0; // Fallback if query fails
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bác Sĩ | Thông Tin Bệnh Nhân</title>

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
        <h5 class="over-title margin-bottom-15">Quản Lý <span class="text-bold">Bệnh Nhân</span></h5>
        <?php
        $vid=$_GET['viewid'];
        $ret=mysqli_query($con,"select * from benhnhan where maBenhNhan='$vid'");
        $cnt=1;
        while ($row=mysqli_fetch_array($ret)) {
         ?>
         <table border="1" class="table table-bordered">
           <tr align="center">
            <td colspan="4" style="font-size:20px;color:blue">
            Chi Tiết Bệnh Nhân</td></tr>

            <tr>
              <th scope>Họ Tên</th>
              <td><?php  echo $row['hoTen'];?></td>
              <th scope>Loại Khám</th>
              <td><?php  echo $row['LoaiBenhNhan'];?></td>
            </tr>
            <tr>
              <th scope>Số Điện Thoại</th>
              <td><?php  echo $row['soDienThoai'];?></td>
              <th>Địa Chỉ</th>
              <td><?php  echo $row['diaChi'];?></td>
            </tr>
            <tr>
              <th>Giới Tính</th>
              <td><?php  echo $row['gioiTinh'];?></td>
              <th>Ngày Sinh</th>
              <td><?php  echo $row['ngaySinh'];?></td>
            </tr>
            

          <?php }?>
        </table>
        <?php

        $ret=mysqli_query($con,"select * from bn_ngoaitru  where MaBenhNhan='$vid'");



        ?>
        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <tr align="center">
           <th colspan="8" >Khám Bệnh</th>
         </tr>
         <tr>
          <th>#</th>
          <th>Mã Bệnh Nhân Ngoại Trú</th>
          <th>Bác Sĩ</th>
		      <th>Chẩn Đoán</th>
          <th>Đơn Thuốc Y Tế</th>
          <th>Ngày Khám</th>
          <th>Ngày Tái Khám</th>
          <th>Phí Khám</th>
        </tr>
        
        <?php
        while ($row=mysqli_fetch_array($ret)) {
          ?>
          <tr>
            <td><?php echo $cnt;?></td>
            <td><?php  echo $row['maBenhAnNgoaiTru'];?></td>
            <td><?php  echo $row['TenBacSi'];?></td>
			<td><?php  echo $row['chanDoan'];?></td>
            <td><?php  echo $row['thuoc'];?></td>
			
            <td><?php  echo $row['ngayKham'];?></td>
            <td><?php  echo $row['ngayKhamTiepTheo'];?></td>
            <td><?php  echo $row['chiPhi'];?></td>
          </tr>
          <?php $cnt=$cnt+1;} ?>
        </table>
       

        <p align="center">
         <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Edit</button></p>

         <?php  ?>
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
           <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered table-hover data-tables">

               <form method="post" name="submit">

                <tr>
                <tr>
    <th>Bác Sĩ:</th>
    <td>
        <select name="dtid" class="form-control wd-450" required="true">
            <?php
            // Query to get all doctors (loaiNhanVien = 'Bác sĩ')
            $result = mysqli_query($con, "SELECT maNV, hoTen FROM nhanvien WHERE loaiNhanVien = 'Bác sĩ'");
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['maNV'] . '">' . $row['hoTen'] . '</option>';
            }
            ?>
        </select>
    </td>
</tr>
						<tr>
                    	<th>Loại Bệnh :</th>
                    	<td>
                      	<textarea  name="sick" placeholder="Loại Bệnh" rows="8" cols="10" class="form-control wd-450" required="true"></textarea></td>
                    	</tr>
                      <tr>
                        <th>Đơn Thuốc:</th>
                        <td>
                          <select name="thuoc[]" multiple class="form-control wd-450" required="true">
                            <?php
                            // Lấy danh sách thuốc từ bảng thuoc
                            $result = mysqli_query($con, "SELECT maThuoc, tenThuoc FROM thuoc");
                            while ($row = mysqli_fetch_array($result)) {
                              echo '<option value="' . $row['maThuoc'] . '">' . $row['tenThuoc'] . '</option>';
                            }
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
    <th>Ngày Khám:</th>
    <td>
        <input type="date" name="ngayKham" class="form-control wd-450" required>
    </td>
</tr>

                            <th>Ngày Tái Khám:</th>
                            <td>
                                <select class="form-control" name="next_appointment" id="next_appointment" required>
                                    <option value="None">Không tái khám </option>
                                    <option value="Choose Date">Chọn ngày tái khám</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="date-container" style="display:none;">
                            <th>Ngày Tái Khám:</th>
                            <td>
                                <input type="date" class="form-control" name="ntk" id="appointment_date" />
                            </td>
                        </tr>

                   

                        </table>
                      </div>
                      <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <button type="submit" name="submit" class="btn btn-primary">Submit</button>

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
 </div>
</div>
</div>

<?php include('include/footer.php');?>
<script>
    document.getElementById('next_appointment').addEventListener('change', function() {
        var optValue = this.value;
        var dateContainer = document.getElementById('date-container');
        var appointmentDate = document.getElementById('appointment_date');
        
        // Hiển thị hoặc ẩn phần nhập ngày tái khám tùy thuộc vào lựa chọn
        if (optValue === 'Choose Date') {
            dateContainer.style.display = 'table-row'; // Hiển thị phần nhập ngày tái khám
        } else {
            dateContainer.style.display = 'none'; // Ẩn phần nhập ngày tái khám
            appointmentDate.value = ''; // Xóa giá trị nếu không cần nhập ngày
        }
    });
</script>
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