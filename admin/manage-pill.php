<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();



?>

<?php
// Kết nối với cơ sở dữ liệu
include('config.php'); // Điều chỉnh tùy vào vị trí và cấu hình kết nối của bạn

if (isset($_GET['deleteid'])) {
    $maThuoc = $_GET['deleteid']; // Lấy ID thuốc cần xóa

    // Bắt đầu giao dịch
    mysqli_begin_transaction($con);

    try {
        // Xóa thuốc khỏi bảng 'thuoc'
        $sql_delete_thuoc = "DELETE FROM thuoc WHERE maThuoc = ?";
        $stmt = mysqli_prepare($con, $sql_delete_thuoc);
        mysqli_stmt_bind_param($stmt, "i", $maThuoc);
        mysqli_stmt_execute($stmt);

        // Xóa các bản ghi liên quan nếu cần thiết (ví dụ, xóa trong bảng 'lothuoc' nếu có liên kết)
        $sql_delete_lothuoc = "DELETE FROM lothuoc WHERE maThuoc = ?";
        $stmt = mysqli_prepare($con, $sql_delete_lothuoc);
        mysqli_stmt_bind_param($stmt, "i", $maThuoc);
        mysqli_stmt_execute($stmt);

        // Nếu không có lỗi, commit giao dịch
        mysqli_commit($con);
        echo "<script>alert('Thuốc đã được xóa thành công.'); window.location.href = 'manage-pill.php';</script>";
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
     
        echo "<script>alert('Có lỗi xảy ra khi xóa thuốc.'); window.location.href = 'manage-pill.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin | Quản Lý Thuốc</title>


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

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            /* Căn giữa các số phân trang */
            gap: 2px;
            /* Khoảng cách giữa các số là 2px */
        }

        .pagination a {
            padding: 8px 12px;
            /* Thêm khoảng cách bên trong */
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ddd;
            /* Thêm viền */
            border-radius: 4px;
            /* Góc bo tròn nhẹ */
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a.active {
            background-color: #007bff;
            /* Màu nền của trang hiện tại */
            color: #fff;
            /* Màu chữ của trang hiện tại */
            border-color: #007bff;
            /* Màu viền của trang hiện tại */
        }

        .pagination a:hover {
            background-color: #0056b3;
            /* Màu nền khi di chuột qua */
            color: white;
            /* Màu chữ khi di chuột qua */
        }
    </style>
</head>

<body class="nav-md">
    <?php
    $page_title = 'Admin | Quản Lý Thuốc';
    $x_content = true;
    ?>
    <?php include('include/header.php'); ?>

    <!-- Thêm nút "Thêm Thuốc" nằm bên phải -->
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="add-pill.php" class="btn btn-primary">Thêm Thuốc</a>
        </div>
    </div>

    <!-- Tìm Kiếm Thuốc -->
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" name="search">
                <div class="form-group">
                    <label for="searchdata">Tìm kiếm tên thuốc</label>
                    <input type="text" name="searchdata" id="searchdata" class="form-control" value="" required='true'>
                </div>
                <button type="submit" name="search" id="submit" class="btn btn-o btn-primary">Tìm kiếm</button>
            </form>

            <?php
            if (isset($_POST['search'])) {
                $sdata = $_POST['searchdata'];
            ?>
                <h4 align="center">Kết quả tìm kiếm cho từ khóa "<?php echo $sdata; ?>"</h4>
                <table class="table table-hover" id="sample-table-1">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Tên Thuốc</th>
                            <th>Công Dụng</th>
                            <th>Giá Cả</th>
                            <th>Ngày Hết Hạn</th>
                            <th>Hết Hạn</th>
                            <th>Tên Nhà Cung Cấp</th>
                            <th>Ngày Nhập</th>
                            <th>Số Lượng</th>
                            <th>Giá Nhập</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Truy vấn thuốc theo từ khóa với thông tin từ lothuoc và nhacungcap
                        $sql = mysqli_query($con, "SELECT thuoc.*, lothuoc.ngayNhap, lothuoc.soLuong, lothuoc.giaNhap, nhacungcap.tenNhaCungCap 
                                               FROM thuoc
                                               LEFT JOIN lothuoc ON thuoc.maLoThuoc = lothuoc.maLoThuoc
                                               LEFT JOIN nhacungcap ON thuoc.maNhaCungCap = nhacungcap.maNhaCungCap
                                               WHERE thuoc.tenThuoc LIKE '%$sdata%'");

                        $num = mysqli_num_rows($sql);
                        if ($num > 0) {
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($sql)) {

                                // Kiểm tra thuốc đã hết hạn
                                $isExpired = (strtotime($row['ngayHetHan']) < time());
                        ?>
                                <tr>
                                    <td class="center"><?php echo $cnt; ?>.</td>
                                    <td><?php echo $row['tenThuoc']; ?></td>
                                    <td><?php echo strlen($row['congDung']) > 50 ? substr($row['congDung'], 0, 50) . '...' : $row['congDung']; ?></td>
                                    <td><?php echo number_format($row['giaCa'], 0, ',', '.') . ' VNĐ'; ?></td>
                                    <td><?php echo $row['ngayHetHan']; ?></td>
                                    <td>
                                        <?php if ($isExpired) { ?>
                                            <i class="fa fa-check text-success"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php echo isset($row['tenNhaCungCap']) ? $row['tenNhaCungCap'] : 'Không có nhà cung cấp'; ?>
                                    </td>
                                    <td>
                                        <?php echo isset($row['ngayNhap']) ? $row['ngayNhap'] : 'Không có ngày nhập'; ?>
                                    </td>
                                    <td>
                                        <?php echo isset($row['soLuong']) ? $row['soLuong'] : 'Không có số lượng'; ?>
                                    </td>
                                    <td><?php echo isset($row['giaNhap']) ? number_format($row['giaNhap'], 0, ',', '.') . ' VNĐ' : 'Không có giá nhập'; ?></td>
                                    <td>
                                        <a href="edit-thuoc.php?editid=<?php echo $row['maThuoc']; ?>"><i class="fa fa-edit"></i></a> |
                                        <a href="view-thuoc.php?mathuoc=<?php echo $row['maThuoc']; ?>"><i class="fa fa-eye"></i></a> |
                                        <a href="manage-pill.php?deleteid=<?php echo $row['maThuoc']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thuốc này?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                                $cnt++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="10">Không có kết quả tìm kiếm nào.</td>
                            </tr>
                    <?php }
                    }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>


    <!-- Hiển thị danh sách thuốc (không tìm kiếm) -->
    <div class="row">
        <div class="col-md-12">
            <h5 class="over-title margin-bottom-15">Quản Lý <span class="text-bold">Thuốc</span></h5>

            <table class="table table-hover" id="sample-table-1">
                <thead>
                    <tr>
                        <th class="center">STT</th>
                        <th>Tên Thuốc</th>
                        <th>Công Dụng</th>
                        <th>Giá Cả</th>
                        <th>Ngày Hết Hạn</th>
                        <th>Hết Hạn</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Ngày Nhập</th>
                        <th>Số Lượng</th>
                        <th>Giá Nhập</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <?php
                // Lấy tổng số thuốc trong cơ sở dữ liệu
                $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM thuoc");
                $result = mysqli_fetch_array($sql);
                $total_rows = $result['total'];

                // Số bản ghi mỗi trang
                $limit = 20;

                // Tính số trang
                $total_pages = ceil($total_rows / $limit);

                // Lấy số trang hiện tại từ URL, mặc định là trang 1
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                // Truy vấn thuốc
                $sql = mysqli_query($con, "SELECT thuoc.*, lothuoc.ngayNhap, lothuoc.soLuong, lothuoc.giaNhap, nhacungcap.tenNhaCungCap 
                                                    FROM thuoc
                                                    JOIN lothuoc ON thuoc.maNhaCungCap = lothuoc.maLoThuoc
                                                    JOIN nhacungcap ON thuoc.maNhaCungCap = nhacungcap.maNhaCungCap
                                           LIMIT $start, $limit");
                $cnt = $start + 1; // Số thứ tự bắt đầu từ vị trí của trang hiện tại
                while ($row = mysqli_fetch_array($sql)) {
                    $isExpired = (strtotime($row['ngayHetHan']) <= time());
                ?>
                    <tr>
                        <td class="center"><?php echo $cnt; ?>.</td>
                        <td><?php echo $row['tenThuoc']; ?></td>
                        <td><?php echo strlen($row['congDung']) > 50 ? substr($row['congDung'], 0, 50) . '...' : $row['congDung']; ?></td>
                        <td><?php echo number_format($row['giaCa'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo $row['ngayHetHan']; ?></td>
                        <td>
                            <?php if ($isExpired) { ?>
                                <i class="fa fa-check text-success"></i>
                            <?php } else { ?>
                                <i class="fa fa-times text-danger"></i>
                            <?php } ?>
                        </td>

                        <td><?php echo $row['tenNhaCungCap']; ?></td>
                        <td><?php echo $row['ngayNhap']; ?></td>
                        <td><?php echo $row['soLuong']; ?></td>
                        <td><?php echo number_format($row['giaNhap'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td>
                            <a href="edit-thuoc.php?editid=<?php echo $row['maThuoc']; ?>"><i class="fa fa-edit"></i></a> |
                            <a href="view-thuoc.php?mathuoc=<?php echo $row['maThuoc']; ?>"><i class="fa fa-eye"></i></a> |
                            <a href="manage-pill.php?deleteid=<?php echo $row['maThuoc']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thuốc này?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php
                    $cnt++; // Tăng giá trị STT lên sau mỗi vòng lặp
                }
                ?>

                </>
            </table>

            <!-- Phân trang -->
            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '">Trang trước</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo '<a href="?page=' . $i . '" class="active">' . $i . '</a>';
                    } else {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>';
                    }
                }
                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '">Trang sau</a>';
                }
                ?>
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