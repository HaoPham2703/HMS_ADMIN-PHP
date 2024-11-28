-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 27, 2024 lúc 04:28 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `final1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2022-06-13 06:53:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `benhnhan`
--

CREATE TABLE `benhnhan` (
  `maBenhNhan` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `ngaySinh` date NOT NULL,
  `gioiTinh` enum('Nam','Nữ') NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `diaChi` text NOT NULL,
  `LoaiBenhNhan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `benhnhan`
--

INSERT INTO `benhnhan` (`maBenhNhan`, `hoTen`, `ngaySinh`, `gioiTinh`, `soDienThoai`, `diaChi`, `LoaiBenhNhan`) VALUES
(155, 'Nguyễn Văn R', '2024-11-06', 'Nam', '0975803788', 'Thái Nguyên', 'Ngoại Trú'),
(156, 'nguyen van a', '2005-03-02', 'Nữ', '0998936719', 'Hồ Chí Minh', 'Nội Trú'),
(157, 'Hoai Duy Tu', '2005-06-05', 'Nam', '0948944234', 'Thái Nguyên', 'Ngoại Trú'),
(158, 'Vu Long Long', '2002-02-02', 'Nam', '0990268864', 'Huế', 'Nội Trú'),
(159, 'Thao Tu Lan', '2009-05-05', 'Nam', '0958288475', 'Huế', 'Nội Trú'),
(160, 'Tien Thu Hieu', '1999-01-01', 'Nam', '0955399046', 'Bà Rịa', 'Ngoại Trú'),
(161, 'Minh Duy Anh', '2001-02-02', 'Nam', '0943390792', 'Bình Dương', 'Nội Trú'),
(162, 'Bui Long Hieu', '1998-01-01', 'Nữ', '0910726552', 'Phú Thọ', 'Nội Trú'),
(163, 'Bui Thanh Hieu', '2006-05-05', 'Nữ', '0929049888', 'Phú Thọ', 'Nội Trú'),
(164, 'Hoang Tu Cao', '2003-01-01', 'Nam', '0902948577', 'Hà Nội', 'Nội Trú'),
(165, 'Dinh Hai Quang', '1995-05-05', 'Nữ', '0956178885', 'Thái Nguyên', 'Ngoại Trú'),
(166, 'Ngoc Thu Quang', '1998-01-01', 'Nữ', '0908291610', 'Huế', 'Ngoại Trú'),
(167, 'Nguyen Tu Binh', '1975-01-01', 'Nữ', '0903121392', 'Bà Rịa', 'Nội Trú'),
(168, 'Ngoc Mai Duy', '2024-11-22', 'Nữ', '0921912848', 'Bình Dương', 'Ngoại Trú'),
(169, 'Thao Thu Anh', '1999-01-01', 'Nữ', '0977039673', 'Cần Thơ', 'Ngoại Trú'),
(170, 'Dang Tuan Quang', '1995-01-01', 'Nữ', '0936657246', 'Đà Nẵng', 'Ngoại Trú'),
(171, 'Hoang Thị Thanh', '1991-11-11', 'Nữ', '0981891142', 'Huế', 'Nội Trú'),
(172, 'Bui Mai Duy', '1999-01-01', 'Nữ', '0913751578', 'Đắk Lắk', 'Nội Trú'),
(173, 'Bui Minh Duy', '2024-10-31', 'Nam', '0993967952', 'Thái Nguyên', 'Nội Trú'),
(174, 'Bui Hai Hieu', '1999-01-01', 'Nam', '0934245034', 'Huế', 'Nội Trú'),
(175, 'Vu Hoang Hieu', '1995-12-15', 'Nam', '0921452157', 'Bà Rịa', 'Ngoại Trú'),
(176, 'Hoang Tuan Binh', '1995-01-01', 'Nam', '0992563468', 'Phú Thọ', 'Nội Trú'),
(177, 'Bui Mai Duy', '1994-01-01', 'Nam', '0913751578', 'Đắk Lắk', 'Nội Trú');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bn_ngoaitru`
--

CREATE TABLE `bn_ngoaitru` (
  `maBenhAnNgoaiTru` varchar(255) NOT NULL,
  `ngayKham` date NOT NULL,
  `chanDoan` text NOT NULL,
  `ngayKhamTiepTheo` date DEFAULT NULL,
  `thuoc` text DEFAULT NULL,
  `chiPhi` decimal(10,2) NOT NULL,
  `maBacSi` int(11) DEFAULT NULL,
  `maBenhNhan` int(11) NOT NULL,
  `TenBacSi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bn_ngoaitru`
--

INSERT INTO `bn_ngoaitru` (`maBenhAnNgoaiTru`, `ngayKham`, `chanDoan`, `ngayKhamTiepTheo`, `thuoc`, `chiPhi`, `maBacSi`, `maBenhNhan`, `TenBacSi`) VALUES
('OP000000155', '2024-11-26', 'ho', '0000-00-00', 'Ibuprofen', 30000.00, 17, 155, 'Hoàng Văn Khoa'),
('OP000000157', '2024-12-05', 'cảm', '2024-12-07', 'Ibuprofen, Losartan, Atorvastatin', 116000.00, 19, 157, 'Võ Văn Hải'),
('OP000000160', '2024-11-13', 'trầm cảm', '2024-11-28', 'Hydroxyzine, Codeine', 70000.00, 19, 160, 'Võ Văn Hải'),
('OP000000165', '2024-11-28', 'ho', '2024-12-08', 'Ibuprofen', 30000.00, 13, 165, 'Nguyễn Văn Hùng'),
('OP000000166', '2024-12-06', 'cảm', '2024-12-01', 'Amoxicillin, Oxycodone', 120000.00, 19, 166, 'Võ Văn Hải'),
('OP000000168', '2024-11-01', 'lao phổi', '0000-00-00', 'Escitalopram, Chlordiazepoxide', 80000.00, 19, 168, 'Võ Văn Hải'),
('OP000000169', '2024-11-19', 'ung thư', '2024-11-29', 'Ibuprofen, Sildenafil, Clopidogrel, Doxycycline, Azithromycin', 167000.00, 21, 169, 'Bùi Văn Lâm'),
('OP000000170', '2024-11-28', 'thiếu máu', '2024-11-30', 'Ibuprofen, Loratadine, Fexofenadine', 80000.00, 21, 170, 'Bùi Văn Lâm'),
('OP000000175', '2024-12-06', 'ho', '2024-12-13', 'Amoxicillin, Ciprofloxacin', 85000.00, 19, 175, 'Võ Văn Hải');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bn_noitru`
--

CREATE TABLE `bn_noitru` (
  `maBenhAnNoiTru` varchar(255) NOT NULL,
  `ngayNhapVien` varchar(255) NOT NULL,
  `ngayXuatVien` varchar(255) DEFAULT NULL,
  `phongBenh` varchar(50) NOT NULL,
  `chiPhi` decimal(10,2) NOT NULL,
  `maBenhNhan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bn_noitru`
--

INSERT INTO `bn_noitru` (`maBenhAnNoiTru`, `ngayNhapVien`, `ngayXuatVien`, `phongBenh`, `chiPhi`, `maBenhNhan`) VALUES
('IP000000156', '2024-11-07', '', '11', 0.00, 156),
('IP000000158', '2024-11-27', '', '2', 0.00, 158),
('IP000000159', '2024-11-30', '2024-11-27', '1', 0.00, 159),
('IP000000161', '2024-11-28', '', '7', 0.00, 161),
('IP000000162', '2024-11-27', '2024-11-27', '6', 0.00, 162),
('IP000000163', '2024-11-30', '', '8', 0.00, 163),
('IP000000164', '2024-11-29', '', '9', 0.00, 164),
('IP000000167', '2024-12-18', '', '15', 0.00, 167),
('IP000000171', '2024-12-04', '', '102', 0.00, 171),
('IP000000172', '2025-01-02', '', '15', 0.00, 172),
('IP000000173', '2024-12-11', '', '11', 0.00, 173),
('IP000000174', '2024-11-23', '2024-11-27', '11', 0.00, 174),
('IP000000176', '2024-12-06', '2024-11-27', '102', 0.00, 176),
('IP000000177', '2024-11-29', '2024-11-27', '8', 0.00, 177);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dieutri`
--

CREATE TABLE `dieutri` (
  `maDieuTri` int(11) NOT NULL,
  `maBenhNhan` varchar(255) NOT NULL,
  `maBacSi` int(11) NOT NULL,
  `maYta` int(11) DEFAULT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date DEFAULT NULL,
  `ketQuaDieuTri` text DEFAULT NULL,
  `ma_thuoc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dieutri`
--

INSERT INTO `dieutri` (`maDieuTri`, `maBenhNhan`, `maBacSi`, `maYta`, `thoiGianBatDau`, `thoiGianKetThuc`, `ketQuaDieuTri`, `ma_thuoc`) VALUES
(53, 'IP000000156', 14, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 1),
(54, 'IP000000156', 17, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 1),
(55, 'IP000000156', 14, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 12),
(56, 'IP000000156', 17, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 12),
(57, 'IP000000156', 14, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 14),
(58, 'IP000000156', 17, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 14),
(59, 'IP000000156', 14, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 29),
(60, 'IP000000156', 17, 16, '2024-11-05', '2024-12-07', 'chưa khỏi', 29),
(61, 'IP000000158', 14, 22, '2024-11-27', '2024-12-06', 'chưa khỏi', 2),
(62, 'IP000000158', 14, 22, '2024-11-27', '2024-12-06', 'chưa khỏi', 23),
(63, 'IP000000158', 14, 22, '2024-11-27', '2024-12-06', 'chưa khỏi', 34),
(64, 'IP000000159', 15, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 31),
(65, 'IP000000159', 21, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 31),
(66, 'IP000000159', 15, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 38),
(67, 'IP000000159', 21, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 38),
(68, 'IP000000159', 15, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 40),
(69, 'IP000000159', 21, 20, '2025-01-04', '2025-01-10', 'chưa khỏi', 40),
(70, 'IP000000161', 14, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 3),
(71, 'IP000000161', 17, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 3),
(72, 'IP000000161', 21, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 3),
(73, 'IP000000161', 14, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 20),
(74, 'IP000000161', 17, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 20),
(75, 'IP000000161', 21, 20, '2024-11-30', '2024-11-29', 'Hồi sức', 20),
(76, 'IP000000162', 14, 16, '2024-11-22', '2024-12-12', 'chuyển viện', 14),
(77, 'IP000000163', 13, 20, '2024-12-04', '2024-12-14', 'trả', 19),
(78, 'IP000000163', 14, 20, '2024-12-04', '2024-12-14', '', 19),
(79, 'IP000000163', 15, 20, '2024-12-04', '2024-12-14', '', 19),
(80, 'IP000000163', 13, 20, '2024-12-04', '2024-12-14', '', 31),
(81, 'IP000000163', 14, 20, '2024-12-04', '2024-12-14', '', 31),
(82, 'IP000000163', 15, 20, '2024-12-04', '2024-12-14', '', 31),
(83, 'IP000000163', 13, 20, '2024-12-04', '2024-12-14', '', 33),
(84, 'IP000000163', 14, 20, '2024-12-04', '2024-12-14', '', 33),
(85, 'IP000000163', 15, 20, '2024-12-04', '2024-12-14', '', 33),
(86, 'IP000000163', 13, 20, '2024-12-04', '2024-12-14', '', 40),
(87, 'IP000000163', 14, 20, '2024-12-04', '2024-12-14', '', 40),
(88, 'IP000000163', 15, 20, '2024-12-04', '2024-12-14', '', 40),
(89, 'IP000000164', 15, 22, '2024-11-29', '2024-12-01', '', 1),
(90, 'IP000000167', 13, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 2),
(91, 'IP000000167', 17, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 2),
(92, 'IP000000167', 13, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 31),
(93, 'IP000000167', 17, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 31),
(94, 'IP000000167', 13, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 32),
(95, 'IP000000167', 17, 20, '2024-12-27', '2024-12-15', 'Hồi sức', 32),
(96, 'IP000000171', 15, 22, '2024-12-05', '2024-12-19', 'Chưa khỏi', 1),
(97, 'IP000000172', 14, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 2),
(98, 'IP000000172', 17, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 2),
(99, 'IP000000172', 14, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 25),
(100, 'IP000000172', 17, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 25),
(101, 'IP000000172', 14, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 27),
(102, 'IP000000172', 17, 20, '2024-12-17', '2024-12-21', 'Chưa khỏi', 27),
(103, 'IP000000173', 15, 22, '2024-12-05', '2025-01-02', 'Chưa khỏi', 3),
(104, 'IP000000174', 14, 18, '2024-11-28', '2024-12-01', 'Chưa khỏi', 3),
(105, 'IP000000174', 14, 18, '2024-11-28', '2024-12-01', 'Chưa khỏi', 26),
(106, 'IP000000174', 14, 18, '2024-11-28', '2024-12-01', 'Chưa khỏi', 27),
(107, 'IP000000176', 15, 22, '2024-12-10', '2024-12-14', 'Chưa khỏi', 2),
(108, 'IP000000177', 13, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 2),
(109, 'IP000000177', 15, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 2),
(110, 'IP000000177', 13, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 30),
(111, 'IP000000177', 15, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 30),
(112, 'IP000000177', 13, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 32),
(113, 'IP000000177', 15, 22, '2024-12-05', '2024-12-14', 'Chưa khỏi', 32),
(114, 'IP000000177', 15, 16, '2024-11-30', '2024-12-13', 'Chưa khỏi', 13);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa`
--

CREATE TABLE `khoa` (
  `maKhoa` int(11) NOT NULL,
  `tieuDe` varchar(100) NOT NULL,
  `truongKhoa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoa`
--

INSERT INTO `khoa` (`maKhoa`, `tieuDe`, `truongKhoa`) VALUES
(1, 'Khoa Răng Hàm Mặt', 13),
(2, 'Khoa Tai Mũi Họng', 14),
(3, 'Khoa Xét Nghiệm', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lothuoc`
--

CREATE TABLE `lothuoc` (
  `maLoThuoc` int(11) NOT NULL,
  `maThuoc` int(11) NOT NULL,
  `maNhaCungCap` int(11) NOT NULL,
  `ngayNhap` date NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaNhap` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lothuoc`
--

INSERT INTO `lothuoc` (`maLoThuoc`, `maThuoc`, `maNhaCungCap`, `ngayNhap`, `soLuong`, `giaNhap`) VALUES
(0, 1, 4, '2024-11-25', 100, 25000.00),
(1, 10, 3, '2024-11-01', 100, 250000.00),
(2, 20, 5, '2024-11-02', 150, 320000.00),
(3, 30, 7, '2024-11-03', 200, 150000.00),
(4, 12, 8, '2024-11-04', 120, 400000.00),
(5, 24, 10, '2024-11-05', 90, 280000.00),
(6, 18, 4, '2024-11-06', 110, 220000.00),
(7, 2, 9, '2024-11-07', 80, 150000.00),
(8, 14, 6, '2024-11-08', 180, 350000.00),
(9, 36, 5, '2024-11-09', 140, 270000.00),
(10, 8, 13, '2024-11-10', 130, 290000.00),
(11, 5, 2, '2024-11-11', 160, 330000.00),
(12, 17, 1, '2024-11-12', 140, 260000.00),
(13, 25, 3, '2024-11-13', 90, 220000.00),
(14, 22, 4, '2024-11-14', 170, 300000.00),
(15, 10, 5, '2024-11-15', 110, 240000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `maNhaCungCap` int(11) NOT NULL,
  `tenNhaCungCap` varchar(100) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `soDienThoai` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`maNhaCungCap`, `tenNhaCungCap`, `diaChi`, `soDienThoai`) VALUES
(0, 'Công Ty Dược Việt Mỹ A', '123 Đường Lý Thường Kiệt, TP. Hồ Chí Minh', '0901234567'),
(2, 'Công Ty Dược Minh Đức', '45 Đường Phạm Văn Đồng, Hà Nội', '0902234567'),
(3, 'Công Ty TNHH Bình An', '789 Đường Nguyễn Văn Linh, Đà Nẵng', '0903234567'),
(4, 'Dược Phẩm Hoa Sen', '567 Đường Trần Hưng Đạo, TP. Cần Thơ', '0904234567'),
(5, 'Nhà Thuốc Hồng Hà', '321 Đường Trần Phú, Hải Phòng', '0905234567'),
(6, 'Công Ty Dược Tâm An', '101 Đường Nguyễn Huệ, TP. Huế', '0906234567'),
(7, 'Dược Phẩm Nam Việt', '234 Đường Võ Thị Sáu, TP. Biên Hòa', '0907234567'),
(8, 'Công Ty Dược An Khánh', '12 Đường Lê Lợi, TP. Vinh', '0908234567'),
(9, 'Công Ty TNHH Dược Lộc Phát', '678 Đường Cách Mạng Tháng Tám, TP. HCM', '0909234567'),
(10, 'Nhà Thuốc Thiên Ân', '98 Đường Nguyễn Trãi, Hà Nội', '0910234567'),
(11, 'Công Ty Dược Hà Thành', '456 Đường Giải Phóng, Hà Nội', '0911234567'),
(12, 'Dược Phẩm Đại Phát', '789 Đường Võ Văn Kiệt, TP. HCM', '0912234567'),
(13, 'Công Ty Dược Ngọc Bích', '345 Đường Hoàng Diệu, Đà Nẵng', '0913234567'),
(14, 'Nhà Thuốc Đông Á', '201 Đường Hai Bà Trưng, TP. Nha Trang', '0914234567'),
(15, 'Công Ty TNHH Dược Bình Minh', '678 Đường Nguyễn Văn Cừ, TP. Cần Thơ', '0915234567'),
(16, 'Dược Phẩm Việt Thắng', '456 Đường Lê Đại Hành, TP. Hải Phòng', '0916234567'),
(17, 'Nhà Thuốc Kim Ngân', '123 Đường Hùng Vương, TP. Đà Lạt', '0917234567'),
(18, 'Công Ty Dược Nam Phong', '987 Đường Nguyễn Đình Chiểu, TP. Mỹ Tho', '0918234567'),
(19, 'Dược Phẩm Hoàng Anh', '654 Đường Phan Châu Trinh, TP. Hội An', '0919234567'),
(20, 'Nhà Thuốc Hoàn Mỹ', '321 Đường Lý Tự Trọng, TP. Rạch Giá', '0920234567'),
(21, 'Nha Cung Cấp A', '', ''),
(22, 'Nha Cung Cấp A', '', ''),
(23, 'Nha Cung Cap A', 'Dia Chi A', '123456789');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `maNV` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `ngaySinh` date NOT NULL,
  `gioiTinh` enum('Nam','Nữ') NOT NULL,
  `diaChi` text NOT NULL,
  `ngayBatDauLam` date NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `chuyenNganh` varchar(100) DEFAULT NULL,
  `namNhanBang` year(4) DEFAULT NULL,
  `loaiNhanVien` enum('Bác sĩ','Y tá') NOT NULL,
  `maKhoa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`maNV`, `hoTen`, `ngaySinh`, `gioiTinh`, `diaChi`, `ngayBatDauLam`, `soDienThoai`, `chuyenNganh`, `namNhanBang`, `loaiNhanVien`, `maKhoa`) VALUES
(13, 'Nguyễn Văn Hùng', '1985-03-12', 'Nam', '123 Đường ABC', '2010-06-20', '0901234567', 'Nội khoa', '2008', 'Bác sĩ', 1),
(14, 'Trần Thị Mai', '1990-07-25', 'Nữ', '456 Đường XYZ', '2015-01-15', '0912345678', 'Ngoại khoa', '2012', 'Bác sĩ', 2),
(15, 'Lê Văn Thành', '1988-12-10', 'Nam', '789 Đường QWE', '2018-05-10', '0923456789', 'Nhi khoa', '2010', 'Bác sĩ', 3),
(16, 'Phạm Thị Lan', '1992-03-30', 'Nữ', '12 Đường RTY', '2020-09-01', '0934567890', 'Da liễu', '2018', 'Y tá', 4),
(17, 'Hoàng Văn Khoa', '1980-08-22', 'Nam', '34 Đường UIO', '2005-11-11', '0945678901', 'Nội khoa', '2003', 'Bác sĩ', 1),
(18, 'Ngô Thị Thu', '1995-11-11', 'Nữ', '56 Đường PAS', '2021-07-19', '0956789012', 'Nhi khoa', '2020', 'Y tá', 3),
(19, 'Võ Văn Hải', '1983-09-05', 'Nam', '78 Đường DFG', '2012-03-10', '0967890123', 'Ngoại khoa', '2010', 'Bác sĩ', 2),
(20, 'Đặng Thị Minh', '1997-04-01', 'Nữ', '90 Đường HJK', '2023-04-15', '0978901234', 'Phục hồi chức năng', '2022', 'Y tá', 5),
(21, 'Bùi Văn Lâm', '1990-02-14', 'Nam', '112 Đường LZX', '2016-08-25', '0989012345', 'Hồi sức cấp cứu', '2014', 'Bác sĩ', 6),
(22, 'Cao Thị Ngân', '1989-07-22', 'Nữ', '134 Đường CVB', '2019-12-30', '0990123456', 'Hỗ trợ điều dưỡng', '2018', 'Y tá', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuoc`
--

CREATE TABLE `thuoc` (
  `maThuoc` int(11) NOT NULL,
  `tenThuoc` varchar(100) NOT NULL,
  `congDung` text NOT NULL,
  `giaCa` int(11) NOT NULL,
  `ngayHetHan` date NOT NULL,
  `maNhaCungCap` int(11) NOT NULL,
  `maLoThuoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thuoc`
--

INSERT INTO `thuoc` (`maThuoc`, `tenThuoc`, `congDung`, `giaCa`, `ngayHetHan`, `maNhaCungCap`, `maLoThuoc`) VALUES
(1, 'Paracetamol', 'Giảm đau, hạ sốt', 30500, '2024-11-19', 0, 0),
(2, 'Ibuprofen', 'Giảm đau, chống viêm', 30000, '2024-11-15', 12, 6),
(3, 'Amoxicillin', 'Kháng sinh điều trị nhiễm khuẩn', 50000, '2026-03-10', 5, 8),
(4, 'Vitamin C', 'Tăng sức đề kháng', 15000, '2024-07-01', 3, 2),
(5, 'Cetirizine', 'Điều trị dị ứng', 25000, '2025-06-20', 15, 14),
(6, 'Loperamide', 'Chống tiêu chảy', 18000, '2024-05-30', 10, 2),
(7, 'Metformin', 'Điều trị tiểu đường', 45000, '2025-09-12', 8, 4),
(8, 'Omeprazole', 'Điều trị đau dạ dày', 35000, '2026-01-25', 2, 7),
(9, 'Aspirin', 'Giảm đau, chống đông máu', 22000, '2025-10-10', 20, 12),
(10, 'Clarithromycin', 'Kháng sinh phổ rộng', 60000, '2024-12-31', 2, 10),
(11, 'Diphenhydramine', 'Điều trị dị ứng, mất ngủ', 22000, '2025-08-15', 17, 13),
(12, 'Loratadine', 'Điều trị dị ứng, mẩn ngứa', 27000, '2025-12-10', 13, 9),
(13, 'Ciprofloxacin', 'Kháng sinh điều trị nhiễm khuẩn', 35000, '2026-02-20', 11, 15),
(14, 'Fexofenadine', 'Điều trị dị ứng, mẩn ngứa', 23000, '2025-07-10', 4, 5),
(15, 'Prednisolone', 'Điều trị viêm, dị ứng', 55000, '2025-05-18', 16, 11),
(16, 'Tamsulosin', 'Điều trị tiểu đêm, phì đại tuyến tiền liệt', 42000, '2026-04-12', 9, 2),
(17, 'Amlodipine', 'Điều trị huyết áp cao', 38000, '2026-01-17', 14, 6),
(18, 'Losartan', 'Điều trị huyết áp cao', 39000, '2025-09-22', 6, 7),
(19, 'Atorvastatin', 'Giảm cholesterol trong máu', 47000, '2026-03-15', 18, 3),
(20, 'Simvastatin', 'Giảm cholesterol trong máu', 46000, '2025-11-05', 19, 8),
(21, 'Sildenafil', 'Điều trị rối loạn cương dương', 30000, '2026-06-12', 7, 4),
(22, 'Ranitidine', 'Điều trị đau dạ dày, trào ngược', 25000, '2024-12-15', 22, 13),
(23, 'Clopidogrel', 'Chống đông máu', 35000, '2025-03-20', 3, 9),
(24, 'Doxycycline', 'Kháng sinh điều trị nhiễm khuẩn', 32000, '2025-09-01', 13, 10),
(25, 'Azithromycin', 'Kháng sinh điều trị nhiễm khuẩn', 40000, '2025-04-10', 20, 15),
(26, 'Fluoxetine', 'Điều trị trầm cảm, lo âu', 48000, '2026-07-01', 11, 5),
(27, 'Escitalopram', 'Điều trị trầm cảm, lo âu', 49000, '2026-05-15', 5, 12),
(28, 'Diazepam', 'Điều trị lo âu, co giật', 35000, '2025-10-20', 18, 10),
(29, 'Chlordiazepoxide', 'Điều trị lo âu, rối loạn giấc ngủ', 31000, '2026-02-28', 9, 14),
(30, 'Lisinopril', 'Điều trị huyết áp cao', 33000, '2025-08-25', 4, 7),
(31, 'Metoprolol', 'Điều trị huyết áp cao, đau thắt ngực', 36000, '2025-07-05', 15, 3),
(32, 'Carvedilol', 'Điều trị huyết áp cao, suy tim', 39000, '2026-03-22', 8, 2),
(33, 'Nitroglycerin', 'Điều trị đau thắt ngực', 27000, '2025-09-15', 19, 13),
(34, 'Atenolol', 'Điều trị huyết áp cao, đau thắt ngực', 34000, '2026-01-30', 17, 15),
(35, 'Hydrochlorothiazide', 'Điều trị huyết áp cao, phù nề', 25000, '2025-11-18', 10, 6),
(36, 'Hydroxyzine', 'Điều trị lo âu, dị ứng', 30000, '2025-06-25', 21, 8),
(37, 'Methylprednisolone', 'Điều trị viêm, dị ứng', 55000, '2026-04-30', 2, 5),
(38, 'Codeine', 'Giảm ho, giảm đau', 40000, '2025-12-12', 14, 12),
(39, 'Oxycodone', 'Giảm đau nặng', 70000, '2026-05-10', 16, 7),
(40, 'Tramadol', 'Giảm đau', 45000, '2025-10-05', 12, 9);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD PRIMARY KEY (`maBenhNhan`),
  ADD KEY `idx_soDienThoai` (`soDienThoai`);

--
-- Chỉ mục cho bảng `bn_ngoaitru`
--
ALTER TABLE `bn_ngoaitru`
  ADD PRIMARY KEY (`maBenhAnNgoaiTru`),
  ADD KEY `maBacSi` (`maBacSi`),
  ADD KEY `fk_maBenhNhan` (`maBenhNhan`);

--
-- Chỉ mục cho bảng `bn_noitru`
--
ALTER TABLE `bn_noitru`
  ADD PRIMARY KEY (`maBenhAnNoiTru`),
  ADD KEY `fk_maBenhNhan_noitru` (`maBenhNhan`);

--
-- Chỉ mục cho bảng `dieutri`
--
ALTER TABLE `dieutri`
  ADD PRIMARY KEY (`maDieuTri`),
  ADD KEY `maBenhNhan` (`maBenhNhan`),
  ADD KEY `maBacSi` (`maBacSi`),
  ADD KEY `maYta` (`maYta`),
  ADD KEY `fk_ma_thuoc` (`ma_thuoc`);

--
-- Chỉ mục cho bảng `khoa`
--
ALTER TABLE `khoa`
  ADD PRIMARY KEY (`maKhoa`),
  ADD KEY `truongKhoa` (`truongKhoa`);

--
-- Chỉ mục cho bảng `lothuoc`
--
ALTER TABLE `lothuoc`
  ADD PRIMARY KEY (`maLoThuoc`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`maNhaCungCap`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`maNV`);

--
-- Chỉ mục cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  ADD PRIMARY KEY (`maThuoc`),
  ADD KEY `fk_nhaCungCap` (`maNhaCungCap`),
  ADD KEY `fk_loThuoc` (`maLoThuoc`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `benhnhan`
--
ALTER TABLE `benhnhan`
  MODIFY `maBenhNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `dieutri`
--
ALTER TABLE `dieutri`
  MODIFY `maDieuTri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `maNhaCungCap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `maNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bn_ngoaitru`
--
ALTER TABLE `bn_ngoaitru`
  ADD CONSTRAINT `fk_maBacSi_ngoaitru` FOREIGN KEY (`maBacSi`) REFERENCES `nhanvien` (`maNV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_maBenhNhan` FOREIGN KEY (`maBenhNhan`) REFERENCES `benhnhan` (`maBenhNhan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `bn_noitru`
--
ALTER TABLE `bn_noitru`
  ADD CONSTRAINT `fk_maBenhNhan_noitru` FOREIGN KEY (`maBenhNhan`) REFERENCES `benhnhan` (`maBenhNhan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dieutri`
--
ALTER TABLE `dieutri`
  ADD CONSTRAINT `dieutri_ibfk_2` FOREIGN KEY (`maBacSi`) REFERENCES `nhanvien` (`maNV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieutri_ibfk_3` FOREIGN KEY (`maYta`) REFERENCES `nhanvien` (`maNV`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ma_thuoc` FOREIGN KEY (`ma_thuoc`) REFERENCES `thuoc` (`maThuoc`);

--
-- Các ràng buộc cho bảng `khoa`
--
ALTER TABLE `khoa`
  ADD CONSTRAINT `khoa_ibfk_1` FOREIGN KEY (`truongKhoa`) REFERENCES `nhanvien` (`maNV`);

--
-- Các ràng buộc cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  ADD CONSTRAINT `fk_loThuoc` FOREIGN KEY (`maLoThuoc`) REFERENCES `lothuoc` (`maLoThuoc`),
  ADD CONSTRAINT `fk_nhaCungCap` FOREIGN KEY (`maNhaCungCap`) REFERENCES `nhacungcap` (`maNhaCungCap`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
