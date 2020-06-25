<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
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
    // Câu lệnh INSERT
    $sql = "INSERT INTO `khachhang` (kh_tendangnhap,kh_matkhau,kh_ten,kh_gioitinh,kh_diachi,kh_dienthoai,kh_email,kh_ngaysinh,kh_thangsinh,kh_namsinh,kh_cmnd,kh_makichhoat,kh_trangthai,kh_quantri) VALUES ('$kh_tendangnhap' , '$kh_matkhau' , '$kh_ten' , $kh_gioitinh, '$kh_diachi' , '$kh_dienthoai, '$kh_email' , $kh_ngaysinh , $kh_thangsinh  ,$kh_namsinh , '$kh_cmnd', '$kh_makichhoat' , $kh_trangthai, $kh_quantri);";

    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}if(isset($_POST['btnCancel'])) {
    header('location:index.php');

}


// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/create.html.twig`
echo $twig->render('backend/khachhang/create.html.twig');