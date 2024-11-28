<?php
session_start();

include('include/config.php');
include('include/checklogin.php');
check_login();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maBenhAnNoiTru = $_POST['maBenhAnNoiTru'];
    $thoiGianBatDau = $_POST['thoiGianBatDau'];
    $thoiGianKetThuc = $_POST['thoiGianKetThuc'];
    $ketQuaDieuTri = isset($_POST['ketQuaDieuTri']) ? $_POST['ketQuaDieuTri'] : '';
    $maThuoc = $_POST['ma_thuoc'];  // Mảng thuốc
    $maBacSi = $_POST['maBacSi'];   // Mảng bác sĩ
    $maYTa = $_POST['maYTa'];       // Y tá

    // Kiểm tra mã bác sĩ và mã y tá hợp lệ
    foreach ($maBacSi as $bacSiId) {
        $query_check_bacsi = mysqli_query($con, "SELECT * FROM nhanvien WHERE maNV = '$bacSiId'");
        if (mysqli_num_rows($query_check_bacsi) == 0) {
            echo "Mã bác sĩ không hợp lệ!";
            exit;  // Nếu bác sĩ không hợp lệ, dừng lại
        }
    }

    // Thực hiện thêm nhiều dòng cho mỗi thuốc và bác sĩ
    foreach ($maThuoc as $thuocId) {
        foreach ($maBacSi as $bacSiId) {
            // Thêm một dòng cho mỗi thuốc và bác sĩ
            $query = "INSERT INTO dieutri (maBenhNhan, thoiGianBatDau, thoiGianKetThuc, ketQuaDieuTri, ma_thuoc, maBacSi, maYTa) 
                      VALUES ('$maBenhAnNoiTru', '$thoiGianBatDau', '$thoiGianKetThuc', '$ketQuaDieuTri', '$thuocId', '$bacSiId', '$maYTa')";

            if (!mysqli_query($con, $query)) {
                // Nếu có lỗi trong câu lệnh SQL
                echo "Lỗi truy vấn: " . mysqli_error($con);
                exit;  // Dừng lại nếu có lỗi
            }
        }
    }

    // Nếu tất cả các dòng đã được thêm thành công
    echo "<script>alert('Dữ liệu đã được thêm thành công!'); window.location.href='patient-inpatients.php';</script>";
}
?>

?>


