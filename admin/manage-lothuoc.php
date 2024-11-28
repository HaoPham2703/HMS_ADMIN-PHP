<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
?>
<!DOCTYPE html>

<head>
    <title>Admin | Quản Lý Lô Thuốc</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../assets/css/custom.min.css" rel="stylesheet">

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 2px;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination a:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>

<body class="nav-md">
    <?php include('include/header.php'); ?>

    <!-- Tìm Kiếm Lô Thuốc -->
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" name="search">
                <div class="form-group">
                    <label for="searchdata">Tìm kiếm lô thuốc</label>
                    <input type="text" name="searchdata" id="searchdata" class="form-control" required='true'>
                </div>
                <button type="submit" name="search" id="submit" class="btn btn-o btn-primary">Tìm kiếm</button>
            </form>

            <?php
            if (isset($_POST['search'])) {
                $sdata = $_POST['searchdata'];
            ?>
                <h4 align="center">Kết quả tìm kiếm cho từ khóa "<?php echo $sdata; ?>"</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Mã Thuốc</th>
                            <th>Tên Thuốc</th>
                            <th>Ngày Nhập</th>
                            <th>Số Lượng</th>
                            <th>Giá Nhập</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM lothuoc INNER JOIN thuoc ON lothuoc.maThuoc = thuoc.maThuoc WHERE thuoc.tenThuoc LIKE '%$sdata%' OR lothuoc.maLoThuoc LIKE '%$sdata%'");
                        $num = mysqli_num_rows($sql);
                        if ($num > 0) {
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($sql)) {
                        ?>
                                <tr>
                                    <td class="center"><?php echo $cnt; ?>.</td>
                                    <td><?php echo $row['maThuoc']; ?></td>
                                    <td><?php echo $row['tenThuoc']; ?></td>
                                    <td><?php echo $row['ngayNhap']; ?></td>
                                    <td><?php echo $row['soLuong']; ?></td>
                                    <td><?php echo number_format($row['giaNhap'], 2); ?></td>
                                    <td>
                                        <a href="edit-lothuoc.php?editid=<?php echo $row['maLoThuoc']; ?>"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            <?php
                                $cnt++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="7">Không có kết quả tìm kiếm nào.</td>
                            </tr>
                    <?php }
                    }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>

    <!-- Hiển Thị Danh Sách Lô Thuốc -->
    <div class="row">
        <div class="col-md-12">
            <h5 class="over-title margin-bottom-15">Quản Lý <span class="text-bold">Lô Thuốc</span></h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="center">STT</th>
                        <th>Mã Thuốc</th>
                        <th>Tên Thuốc</th>
                        <th>Ngày Nhập</th>
                        <th>Số Lượng</th>
                        <th>Giá Nhập</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = mysqli_query($con, "SELECT * FROM lothuoc INNER JOIN thuoc ON lothuoc.maThuoc = thuoc.maThuoc");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td class="center"><?php echo $cnt; ?>.</td>
                            <td><?php echo $row['maThuoc']; ?></td>
                            <td><?php echo $row['tenThuoc']; ?></td>
                            <td><?php echo $row['ngayNhap']; ?></td>
                            <td><?php echo $row['soLuong']; ?></td>
                            <td><?php echo number_format($row['giaNhap'], 2); ?></td>
                            <td>
                                <a href="edit-lothuoc.php?editid=<?php echo $row['maLoThuoc']; ?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php
                        $cnt++;
                    }
                    ?>
                </tbody>
            </table>
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