<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

/* --- 
   --- 2.Truy vấn dữ liệu hihh thuc thanh toan
   --- 
*/
// Chuẩn bị câu truy vấn Loại sản phẩm
$sqlHTTT = "select * from `hinhthucthanhtoan`";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultHTTT = mysqli_query($conn, $sqlHTTT);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataHTTT = [];
while($rowHTTT = mysqli_fetch_array($resultHTTT, MYSQLI_ASSOC))
{
    $dataHTTT[] = array(
        'httt_ma' => $rowHTTT['httt_ma'],
        'httt_ten' => $rowHTTT['httt_ten'],

    );
}
/* --- End Truy vấn dữ liệu hình thức thanh toán --- */

/* --- 
   --- 3. Truy vấn dữ liệu khách hàng
   --- 
*/
// Chuẩn bị câu truy vấn Nhà sản xuất
$sqlKhachHang = "select kh.kh_ma, kh.kh_ten from `khachhang` kh";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultKhachHang = mysqli_query($conn, $sqlKhachHang);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataKhachHang = [];
while($rowKhachHang = mysqli_fetch_array($resultKhachHang, MYSQLI_ASSOC))
{
    $dataKhachHang[] = array(
        'kh_ma' => $rowKhachHang['kh_ma'],
        'kh_ten' => $rowKhachHang['kh_ten'],
    );
}
/* --- End Truy vấn dữ liệu khách hàng --- */




// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $dh_ngaylap = $_POST['dh_ngaylap'];
    $dh_ngaygiao = $_POST['dh_ngaygiao'];
    $dh_noigiao = $_POST['dh_noigiao'];
    $dh_trangthaithanhtoan = $_POST['dh_trangthaithanhtoan'];
    $httt_ma = $_POST['httt_ma'];
    $kh_ma = $_POST['kh_ma'];
    // Câu lệnh INSERT
    $sql = "INSERT INTO `dondathang` (dh_ngaylap, dh_ngaygiao, dh_noigiao, dh_trangthaithanhtoan, httt_ma, kh_ma) VALUES ('$dh_ngaylap', $dh_ngaygiao, $dh_noigiao, '$dh_trangthaithanhtoan', '$httt_ma', '$kh_ma');";
    
    // Thực thi INSERT
    mysqli_query($conn, $sql);
    // var_dump($sql);die;
    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');

}
// var_dump($dataHTTT,$dataKhachHang);die;
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/create.html.twig`
echo $twig->render('backend/dondathang/create.html.twig', [
    'ds_HTTT' => $dataHTTT,
    'ds_KhachHang' => $dataKhachHang  
]);

