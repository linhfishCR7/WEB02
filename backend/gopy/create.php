<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

// Chuẩn bị câu truy vấn Chu đề gopys ý
$sqlChuDeGopY = "select * from `chudegopy`";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultChuDeGopY = mysqli_query($conn, $sqlChuDeGopY);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataChuDeGopY= [];
while($rowChuDeGopY = mysqli_fetch_array($resultChuDeGopY, MYSQLI_ASSOC))
{
    $dataChuDeGopY[] = array(
        'cdgy_ma' => $rowChuDeGopY['cdgy_ma'],
        'cdgy_ten' => $rowChuDeGopY['cdgy_ten'],
        
    );
}

/* --- End Truy vấn dữ liệu Khuyến mãi --- */

// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{

    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $gy_hoten = $_POST['gy_hoten'];
    $gy_email = $_POST['gy_email'];
    $gy_diachi = $_POST['gy_diachi'];
    $gy_dienthoai = number_format($_POST['gy_dienthoai'], 0, ".", ",");
    $gy_tieude = $_POST['gy_tieude'];
    $gy_noidung = $_POST['gy_noidung'];
    $gy_ngaygopy = date('d/m/Y H:i:s', strtotime($_POST['gy_ngaygopy']));
    $cdgy_ma = $_POST['cdgy_ma'];

    // Câu lệnh INSERT
    $sql = "INSERT INTO `gopy` (gy_hoten, gy_email, gy_diachi, gy_dienthoai, gy_tieude, gy_noidung, gy_ngaygopy,cdgy_ma) VALUES ('$gy_hoten', '$gy_email', '$gy_diachi', '$gy_dienthoai', '$gy_tieude', '$gy_noidung', '$gy_ngaygopy',$cdgy_ma);";
    
    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/create.html.twig`
echo $twig->render('backend/gopy/create.html.twig', [
    'ds_chudegopy' => $dataChuDeGopY
    
]);