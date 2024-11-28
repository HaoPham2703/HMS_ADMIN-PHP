<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');

if (isset($_GET['del'])) {
    // Lấy MaBenhNhan từ URL
    $maBenhNhan = $_GET['id'];

    // Thực thi truy vấn xóa
    $sql = mysqli_query($con, "DELETE FROM benhnhan WHERE maBenhNhan = '$maBenhNhan'");

    // Kiểm tra và hiển thị thông báo
    if ($sql) {
    
        echo "<script>alert('Xóa thành công!'); window.location.href='manage-patient.php';</script>";
    } else {
        $_SESSION['msg'] = "Xóa thất bại!";
        echo "<script>alert('Có lỗi xảy ra khi xóa bản ghi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin | View Patients</title>

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
	<link href="../assets/css/custom.min.css" rel="stylesheet">
</head>
<body class="nav-md">
	<style>
		/* Định dạng tổng thể cho phần phân trang */
.pagination {
    text-align: center;
    margin-top: 20px;
    font-family: Arial, sans-serif;
}

/* Định dạng các phần tử li trong phân trang */
.pagination ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
}

/* Định dạng các liên kết phân trang */
.pagination a {
    color: #007bff; /* Màu xanh cho liên kết */
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    margin: 0 4px;
    font-size: 14px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

/* Màu sắc khi di chuột vào liên kết phân trang */
.pagination a:hover {
    background-color: #f1f1f1;
    color: #0056b3;
}

/* Định dạng trang hiện tại */
.pagination .active a {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
}

/* Định dạng các nút disabled (không hoạt động) */
.pagination .disabled a {
    color: #6c757d;
    pointer-events: none;
    background-color: #e9ecef;
    border: 1px solid #ddd;
}

/* Định dạng cho các nút "Previous" và "Next" */
.pagination .prev, .pagination .next {
    font-weight: bold;
    padding: 8px 16px;
}

/* Định dạng các nút "Previous" và "Next" khi không hoạt động */
.pagination .disabled .prev, .pagination .disabled .next {
    background-color: #f1f1f1;
    color: #6c757d;
    border: 1px solid #ddd;
    pointer-events: none;
}

	</style>
	<?php
	$page_title = 'Admin | Quản Lý Bệnh Nhân';
	$x_content = true;
	?>
	<?php include('include/header.php');?>
	<?php
// Số dòng mỗi trang
$limit = 15;

// Lấy số trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính toán vị trí bắt đầu của kết quả trong câu truy vấn
$start = ($page - 1) * $limit;

// Truy vấn tổng số bệnh nhân
$sql_count = mysqli_query($con, "SELECT COUNT(*) AS total FROM benhnhan");
$row_count = mysqli_fetch_assoc($sql_count);
$total_rows = $row_count['total'];  // Tổng số dòng trong bảng

// Tính toán số trang cần hiển thị
$total_pages = ceil($total_rows / $limit);

// Truy vấn dữ liệu bệnh nhân với phân trang
$sql = mysqli_query($con, "SELECT * FROM benhnhan LIMIT $start, $limit");
?>

<div class="row">
    <div class="col-md-12">
        <h5 class="over-title margin-bottom-15">Quản Lý <span class="text-bold">Bệnh Nhân</span></h5>

        <table class="table table-hover" id="sample-table-1">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th>Tên Bệnh Nhân</th>
                    <th>Số điện thoại</th>
                    <th>Giới tính </th>
                    <th>Địa chỉ </th>
                    <th>Điều Trị</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cnt = $start + 1; // Đánh số bắt đầu từ vị trí $start + 1
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td class="center"><?php echo $cnt; ?>.</td>
                    <td class="hidden-xs"><?php echo $row['hoTen']; ?></td>
                    <td><?php echo $row['soDienThoai']; ?></td>
                    <td><?php echo $row['gioiTinh']; ?></td>
                    <td><?php echo $row['diaChi']; ?></td>
                    <td><?php echo $row['LoaiBenhNhan']; ?></td>
                    <td>
                        <a href="edit-patient.php?editid=<?php echo $row['maBenhNhan']; ?>"><i class="fa fa-edit"></i></a>
                        <a href="manage-patient.php?id=<?php echo $row['maBenhNhan']; ?>&del=delete" 
                            onClick="return confirm('Are you sure you want to delete?')" 
                            class="btn btn-transparent btn-xs tooltips" 
                            tooltip-placement="top" tooltip="Remove">
                            <i class="fa fa-times fa fa-white"></i>
                        </a>
                    </td>
                </tr>
                <?php
                $cnt++;
                }
                ?>
            </tbody>
        </table>

        <!-- Phân trang -->
		<div class="pagination">
    <ul class="pagination">
     

        <!-- Hiển thị các liên kết số trang -->
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? 'active' : '';
            echo "<li class='$active'><a href='manage-patient.php?page=$i'>$i</a></li>";
        }
        ?>

       
    </ul>
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