<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maBenhNhan = $_POST['maBenhNhan'];
    $ngayNhapVien = $_POST['ngayNhapVien'];
    $ngayXuatVien = $_POST['ngayXuatVien'];
    $phongBenh = $_POST['phongBenh'];
    
    // Dữ liệu chi tiết điều trị
    $thoiGianBatDau = $_POST['thoiGianBatDau'];
    $thoiGianKetThuc = $_POST['thoiGianKetThuc'];
    $ketQuaDieuTri = $_POST['ketQuaDieuTri'];
    $ma_thuoc = implode(',', $_POST['ma_thuoc']);
    $maBacSi = implode(',', $_POST['maBacSi']);
    $maYTa = $_POST['maYTa'];

    // Cập nhật thông tin nội trú
    $query_update_inpatient = "
        UPDATE bn_noitru
        SET 
            ngayNhapVien = '$ngayNhapVien',
            ngayXuatVien = '$ngayXuatVien',
            phongBenh = '$phongBenh'
        WHERE maBenhNhan = '$maBenhNhan'
    ";

    if (mysqli_query($con, $query_update_inpatient)) {
        // Thêm chi tiết điều trị
        $query_insert_dieutri = "
            INSERT INTO dieutri (maBenhNhan, maBacSi, maYta, thoiGianBatDau, thoiGianKetThuc, ketQuaDieuTri, ma_thuoc)
            VALUES ('$maBenhNhan', '$maBacSi', '$maYTa', '$thoiGianBatDau', '$thoiGianKetThuc', '$ketQuaDieuTri', '$ma_thuoc')
        ";

        if (mysqli_query($con, $query_insert_dieutri)) {
            $_SESSION['msg'] = "Cập nhật và thêm điều trị thành công!";
        } else {
            $_SESSION['error'] = "Lỗi khi thêm điều trị: " . mysqli_error($con);
        }
    } else {
        $_SESSION['error'] = "Lỗi khi cập nhật thông tin nội trú: " . mysqli_error($con);
    }

    header('Location: patient-inpatients.php');
    exit();
}
?>
