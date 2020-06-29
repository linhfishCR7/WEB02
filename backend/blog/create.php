<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');



// Chuẩn bị câu truy vấn Loại sản phẩm
$sqlLoaiSanPham = "select * from `loaisanpham`";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultLoaiSanPham = mysqli_query($conn, $sqlLoaiSanPham);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataLoaiSanPham = [];
while($rowLoaiSanPham = mysqli_fetch_array($resultLoaiSanPham, MYSQLI_ASSOC))
{
    $dataLoaiSanPham[] = array(
        'lsp_ma' => $rowLoaiSanPham['lsp_ma'],
        'lsp_ten' => $rowLoaiSanPham['lsp_ten'],
        'lsp_mota' => $rowLoaiSanPham['lsp_mota'],
    );
}


/* --- 
   --- 3. Truy vấn dữ liệu Nhà sản xuất 
   --- 
*/
// Chuẩn bị câu truy vấn Nhà sản xuất
$sqlKhachHang = "select * from `khachhang`";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultKhachHang = mysqli_query($conn, $sqlKhachHang);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataKhachHang = [];
while($rowKhacHang = mysqli_fetch_array($resultKhachHang, MYSQLI_ASSOC))
{
    $dataKhachHang[] = array(
        'kh_ma' => $rowKhacHang['kh_ma'],
        'kh_tendangnhap' => $rowKhacHang['kh_tendangnhap'],
    );
}
/* --- 
   --- 2.Truy vấn dữ liệu sản phẩm 
   --- 
*/

/* --- End Truy vấn dữ liệu sản phẩm --- */

// 3. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{

    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $bl_chude = $_POST['bl_chude'];
    $bl_mota_ngan = $_POST['bl_mota_ngan'];
    $bl_noidung = $_POST['bl_noidung'];
    $bl_ngay = $_POST['bl_ngay'];
    $bl_tags = $_POST['bl_tags'];
    $lsp_ma = $_POST['lsp_ma'];
    $kh_ma = $_POST['kh_ma'];

    
    // Câu lệnh INSERT
    $sql = "INSERT INTO `blog` (bl_chude,bl_mota_ngan, bl_noidung, bl_ngay, bl_tags,lsp_ma, kh_ma) VALUES ('$bl_chude', '$bl_mota_ngan','$bl_noidung', '$bl_ngay', '$bl_tags',$lsp_ma, $kh_ma);";
    // $sqlhinhanh = "INSERT INTO `hinhblog` (hb_tentaptin) VALUES ('$tentaptin');";
        
   
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);


    // Nếu người dùng có chọn file để upload
    
    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/hinhsanpham/create.html.twig`
echo $twig->render('backend/blog/create.html.twig', [
    'ds_loaisanpham' => $dataLoaiSanPham,
    'ds_khachhang' => $dataKhachHang
]);