<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

/* --- 
   --- 2.Truy vấn dữ liệu Loại sản phẩm 
   --- 
*/
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
   --- 5. Truy vấn dữ liệu Sản phẩm theo khóa chính
   --- 
*/
// Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$bl_ma = $_GET['bl_ma'];
$sqlSelect = "SELECT * FROM `blog` WHERE bl_ma=$bl_ma;";

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$sanphamRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record
/* --- End Truy vấn dữ liệu Sản phẩm theo khóa chính --- */

// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
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
    $sql = "UPDATE `blog` SET bl_chude='$bl_chude', bl_mota_ngan='$bl_mota_ngan', bl_noidung='$bl_noidung', bl_ngay='$bl_ngay', bl_tags='$bl_tags', lsp_ma=$lsp_ma, kh_ma=$kh_ma WHERE bl_ma=$bl_ma;";
    
    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/edit.html.twig`
echo $twig->render('backend/blog/edit.html.twig', [
    'ds_loaisanpham' => $dataLoaiSanPham,
    'ds_khachhang' => $dataKhachHang,
    'blog' => $sanphamRow

]);