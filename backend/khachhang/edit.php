<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$kh_ma = $_GET['kh_ma'];
$sqlSelect = "SELECT * FROM `khachhang` WHERE kh_ma=$kh_ma;";


// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$khachhangRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record
// var_dump($khachhangRow);die;
// 4. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $kh_tendangnhap = $_POST['kh_tendangnhap'];
    $kh_matkhau = $_POST['kh_matkhau'];
    $kh_ten = $_POST['kh_ten'];
    $kh_gioitinh = $_POST['kh_gioitinh'];
    $kh_diachi = $_POST['kh_diachi'];
    $kh_dienthoai = $_POST['kh_dienthoai'];
    $kh_email = $_POST['kh_email'];
    $kh_ngaysinh = $_POST['kh_ngaysinh'];
    $kh_thangsinh = $_POST['kh_thangsinh'];
    $kh_namsinh = $_POST['kh_namsinh'];
    $kh_cmnd = $_POST['kh_cmnd'];
    $kh_makichhoat = $_POST['kh_makichhoat'];
    $kh_trangthai = $_POST['kh_trangthai'];
    $kh_quantri = $_POST['kh_quantri'];


    // Câu lệnh UPDATE
    $sql = "UPDATE `khachhang` SET kh_tendangnhap=$kh_tendangnhap, kh_matkhau='$kh_matkhau',kh_ten='$kh_ten',kh_gioitinh='$kh_gioitinh',kh_diachi='$kh_diachi',kh_dienthoai='$kh_dienthoai',kh_email='$kh_email',kh_ngaysinh='$kh_ngaysinh',kh_thangsinh='$kh_thangsinh',kh_namsinh='$kh_namsinh',kh_cmnd='$kh_cmnd',kh_makichhoat='$kh_makichhoat',kh_trangthai='$kh_trangthai',kh_quantri='$kh_quantri' WHERE kh_ma=$kh_ma;";

    // Thực thi UPDATE
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}if(isset($_POST['btnCancel'])) {
    header('location:index.php');

}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/edit.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `loaisanpham`
echo $twig->render('backend/khachhang/edit.html.twig', ['khachhang' => $khachhangRow] );