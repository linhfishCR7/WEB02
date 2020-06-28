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
$sqlSanPham = "select sp.sp_ma, sp.sp_ten from `sanpham` sp";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultSanPham = mysqli_query($conn, $sqlSanPham);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataSanPham = [];
while($rowSanPham = mysqli_fetch_array($resultSanPham, MYSQLI_ASSOC))
{
    $dataSanPham[] = array(
        'sp_ma' => $rowSanPham['sp_ma'],
        'sp_ten' => $rowSanPham['sp_ten'],

    );
}
/* --- End Truy vấn dữ liệu hình thức thanh toán --- */

/* --- 
   --- 3. Truy vấn dữ liệu khách hàng
   --- 
*/
// Chuẩn bị câu truy vấn Nhà sản xuất
$sqlDonHang = "select dh.dh_ma from `dondathang` dh";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDonHang = mysqli_query($conn, $sqlDonHang);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDonHang = [];
while($rowDonHang = mysqli_fetch_array($resultDonHang, MYSQLI_ASSOC))
{
    $dataDonHang[] = array(
        'dh_ma' => $rowDonHang['dh_ma'],
    );
}
/* --- End Truy vấn dữ liệu khách hàng --- */




// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $sp_ma = $_POST['sp_ma'];
    $dh_ma = $_POST['dh_ma'];
    $sp_dh_soluong = $_POST['sp_dh_soluong'];
    $sp_dh_dongia = $_POST['sp_dh_dongia'];
    
    // Câu lệnh INSERT
    $sql = "INSERT INTO `sanpham_dondathang` (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia) VALUES ($sp_ma, $dh_ma, $sp_dh_soluon, $sp_dh_dongia);";
    
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
echo $twig->render('backend/sanpham_dondathang/create.html.twig', [
    'ds_SanPham' => $dataSanPham,
    'ds_DonHang' => $dataDonHang  
]);

