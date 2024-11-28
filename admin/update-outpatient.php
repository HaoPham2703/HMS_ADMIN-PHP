<?php
// Kết nối cơ sở dữ liệu
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
include('db_connection.php'); // Thay bằng file kết nối của bạn

// Kiểm tra nếu form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $maBenhAnNgoaiTru = $_POST['maBenhAnNgoaiTru'];
    $chanDoan = $_POST['chanDoan'];
    $ngayKhamTiepTheo = $_POST['ngayKhamTiepTheo'];
    $thuoc = $_POST['thuoc'];
    $chiPhi = $_POST['chiPhi'];
    $maBacSi = $_POST['maBacSi'];

    // Truy vấn UPDATE
    $sql = "
        UPDATE bn_ngoaitru
        SET 
            chanDoan = '$chanDoan',
            ngayKhamTiepTheo = '$ngayKhamTiepTheo',
            thuoc = '$thuoc',
            chiPhi = $chiPhi,
            maBacSi = '$maBacSi'
        WHERE 
            maBenhAnNgoaiTru = '$maBenhAnNgoaiTru'
    ";

    // Thực thi truy vấn
    if (mysqli_query($con, $sql)) {
        // Cập nhật thành công
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='patient-outpatients.php';</script>";
    } else {
        // Lỗi khi cập nhật
        echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
}
?>
