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

  

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
if(isset($_POST['btnCancel'])) {
    header('location:index.php');

}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/edit.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `loaisanpham`
echo $twig->render('backend/khachhang/detail.html.twig', ['khachhang' => $khachhangRow] );