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
$sqlGopY = "select blog.bl_ma, blog.bl_chude from `blog`";

// Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultGopY = mysqli_query($conn, $sqlGopY);

// Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataGopY= [];
while($rowGopY = mysqli_fetch_array($resultGopY, MYSQLI_ASSOC))
{
    $dataGopY[] = array(
        'bl_ma' => $rowGopY['bl_ma'],
        'bl_chude' => $rowGopY['bl_chude'],

        
    );
}


/* --- 
   --- 5. Truy vấn dữ liệu Sản phẩm theo khóa chính
   --- 
*/
// Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$gy_bl_ma = $_GET['gy_bl_ma'];
$sqlSelect = "SELECT * FROM `gopy_blog` WHERE gy_bl_ma=$gy_bl_ma;";

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$gopyRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record
/* --- End Truy vấn dữ liệu Sản phẩm theo khóa chính --- */

// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $gy_bl_noidung = $_POST['gy_bl_noidung'];
    $bl_ma = $_POST['bl_ma'];

    // Câu lệnh INSERT
    $sql = "UPDATE `gopy_blog` SET gy_bl_noidung='$gy_bl_noidung', bl_ma=$bl_ma WHERE gy_bl_ma=$gy_bl_ma;";
    
    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/edit.html.twig`
echo $twig->render('backend/gopyblog/edit.html.twig', [
    'ds_gopy' => $dataGopY,
    'gopy' => $gopyRow,
]);