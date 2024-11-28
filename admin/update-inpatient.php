<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

// Kiểm tra nếu phương thức POST được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maBenhNhan = $_POST['maBenhNhan'];
    $ngayNhapVien = $_POST['ngayNhapVien'];
    $ngayXuatVien = $_POST['ngayXuatVien'];
    $phongBenh = $_POST['phongBenh'];

    // Cập nhật thông tin nội trú
    $query_update_inpatient = "
    UPDATE bn_noitru
    SET 
        ngayNhapVien = '$ngayNhapVien',
        ngayXuatVien = '$ngayXuatVien',
        phongBenh = '$phongBenh'
    WHERE maBenhNhan = '$maBenhNhan'
    ";

    // Kiểm tra xem có cập nhật thành công không
    if (mysqli_query($con, $query_update_inpatient)) {
        $_SESSION['msg'] = "Cập nhật thông tin nội trú thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi cập nhật thông tin: " . mysqli_error($con);
    }

    // Điều hướng về trang trước
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// Trả về thông báo và thông tin đã cập nhật
if (isset($_SESSION['msg'])) {
    echo "<h3>" . $_SESSION['msg'] . "</h3>";
    unset($_SESSION['msg']);
} elseif (isset($_SESSION['error'])) {
    echo "<h3>" . $_SESSION['error'] . "</h3>";
    unset($_SESSION['error']);
}
?>
