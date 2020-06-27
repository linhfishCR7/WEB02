<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__ . '/../../bootstrap.php';

// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../../dbconnect.php');


if (!isset($_POST['btnDatHang'])) {
    // Nếu trong SESSION có giá trị của key 'email' <-> người dùng đã đăng nhập thành công
    // Nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
    if (!isset($_SESSION['email_logged'])) {
        header('location:../auth/login.php');
        return;
    }

    // Hiển thị trang thanh toán
    // Lấy thông tin Hình thức thanh toán
    // Câu lệnh SELECT
    $sqlSelectHinhThucThanhToan = <<<EOT
        SELECT * 
        FROM `hinhthucthanhtoan`
    EOT;

    // Thực thi SELECT
    $resultSelectHinhThucThanhToan = mysqli_query($conn, $sqlSelectHinhThucThanhToan);
    $dataPaymentTypes = [];
    while ($row = mysqli_fetch_array($resultSelectHinhThucThanhToan, MYSQLI_ASSOC)) {
        $dataPaymentTypes[] = array(
            'httt_ma' => $row['httt_ma'],
            'httt_ten' => $row['httt_ten'],
            
        );
    }

    // Lấy thông tin khách hàng
    // Lấy dữ liệu người dùng đã đăng nhập từ SESSION
    $email = $_SESSION['email_logged'];

    // Câu lệnh SELECT
    $sqlSelect = <<<EOT
        SELECT *
        FROM `khachhang`
        WHERE kh_email = '$email'
        LIMIT 1;
    EOT;

    // Thực thi SELECT
    $result = mysqli_query($conn, $sqlSelect);
    $dataCustomer;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $dataCustomer = array(
            'kh_ma' => $row['kh_ma'],
            'kh_tendangnhap' => $row['kh_tendangnhap'],
            'kh_ten' => $row['kh_ten'],
            'kh_gioitinh' => $row['kh_gioitinh'],
            'kh_email' => $row['kh_email'],
            'kh_diachi' => $row['kh_diachi'],
            'kh_dienthoai' => $row['kh_dienthoai'],
            'kh_cmnd' => $row['kh_cmnd'],
            // Sử dụng hàm date($format, $timestamp) để chuyển đổi ngày thành định dạng Việt Nam (ngày/tháng/năm)
            // Do hàm date() nhận vào là đối tượng thời gian, chúng ta cần sử dụng hàm strtotime() để chuyển đổi từ chuỗi có định dạng 'yyyy-mm-dd' trong MYSQL thành đối tượng ngày tháng
            'kh_ngaysinh' => $row['kh_ngaysinh'],
            'kh_thangsinh' => $row['kh_thangsinh'],
            'kh_namsinh' => $row['kh_namsinh'],
        );
    }

    // Kiểm tra dữ liệu trong session
    $data = [];
    if (isset($_SESSION['giohangdata'])) {
        $data = $_SESSION['giohangdata'];
    } else {
        $data = [];
    }

    // Yêu cầu `Twig` vẽ giao diện được viết trong file `frontend/checkout/onepage-checkout.html.twig`
    // với dữ liệu truyền vào file giao diện được đặt tên là `cartdata`
    echo $twig->render('frontend/checkout/thanhtoan.html.twig', [
        'giohangdata' => $data,
        'hinhthucthanhtoan' => $dataPaymentTypes,
        'khachhang' => $dataCustomer
    ]);
    return;
}
    // vardump($cartdata);die;
// Lưu đơn hàng
// dd($_POST);
// Lấy dữ liệu từ POST
$kh_tendangnhap = $_POST['kh_ten'];
$httt_ma = $_POST['httt_ma'];
$dh_ngaylap = date('Y-m-d H:m:s'); // lấy ngày hiện tại
$dh_trangthaithanhtoan = 0; // 0: Đơn hàng chưa xử lý

// Insert Đơn hàng
// Câu lệnh INSERT
$sqlDonHang = "INSERT INTO `dondathang` (dh_ngaylap, dh_ngaygiao, dh_noigiao, dh_trangthaithanhtoan, httt_ma, kh_ten) VALUES ('$dh_ngaylap', null, null, $dh_trangthaithanhtoan, $httt_ma, '$kh_tendangnhap');";
// dd($sqlDonHang);

// Thực thi INSERT
mysqli_query($conn, $sqlDonHang);

// Lấy ID đơn hàng vừa được lưu
$last_donhang_id = mysqli_insert_id($conn);

// Duyệt vòng lặp sản phẩm trong giỏ hàng để thực thi câu lệnh INSERT vào table `sanpham_donhang`
foreach ($_POST['sanphamgiohang'] as $sanpham) {
    $sp_ma = $sanpham['sp_ma'];
    $gia = $sanpham['gia'];
    $soluong = $sanpham['soluong'];

    // Insert Sản phẩm Đơn hàng
    // Câu lệnh INSERT
    $sqlSanPhamDonHang = "INSERT INTO `sanpham_dondathang` (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia) VALUES ($sp_ma, $last_donhang_id, $soluong, $gia);";

    // Thực thi INSERT
    mysqli_query($conn, $sqlSanPhamDonHang);
}

// Thanh toán thành công, xóa Giỏ hàng trong SESSION
// lưu dữ liệu giỏ hàng vào session
$_SESSION['giohangdata'] = [];

echo $twig->render('frontend/checkout/thanhtoan-finish.html.twig');