<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

/* --- 
   --- 2.Truy vấn dữ liệu
   --- 
*/
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


/* --- 
   --- 5. Truy vấn dữ liệu Sản phẩm theo khóa chính
   --- 
*/
// Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$gy_ma = $_GET['gy_ma'];
$sqlSelect = "SELECT * FROM `gopy` WHERE gy_ma=$gy_ma;";

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$gopyRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record
/* --- End Truy vấn dữ liệu Sản phẩm theo khóa chính --- */

// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $gy_hoten = $_POST['gy_hoten'];
    $gy_email = $_POST['gy_email'];
    $gy_diachi = $_POST['gy_diachi'];
    $gy_dienthoai = $_POST['gy_dienthoai'];
    $gy_tieude = $_POST['gy_tieude'];
    $gy_noidung = $_POST['gy_noidung'];
    $gy_ngaygopy = date('d/m/Y H:i:s', strtotime($_POST['gy_ngaygopy']));
    $cdgy_ma = $_POST['cdgy_ma'];

    // Câu lệnh INSERT
    $sql = "UPDATE `gopy` SET gy_hoten='$gy_hoten', gy_email='$gy_email', gy_diachi='$gy_diachi', gy_dienthoai='$gy_dienthoai', gy_tieude='$gy_tieude', gy_noidung='$gy_noidung', gy_ngaygopy='$gy_ngaygopy', cdgy_ma=$cdgy_ma WHERE gy_ma=$gy_ma;";
    
    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/edit.html.twig`
echo $twig->render('backend/gopy/edit.html.twig', [
    'ds_chudegopy' => $dataChuDeGopY,
    'gopy' => $gopyRow,
]);