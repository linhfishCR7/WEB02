<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// 2. Chuẩn bị câu truy vấn $sql
// Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
$sql = <<<EOT
    SELECT spddh.*, sp.sp_ma, dh.dh_ma
    FROM `sanpham_dondathang` spddh
    JOIN `sanpham` sp ON spddh.sp_ma = sp.sp_ma
    JOIN `dondathang` dh ON spddh.dh_ma = dh.dh_ma
EOT;

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sql);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   
    
    $data[] = array(
        'sp_ma' => $row['sp_ma'],
        'dh_ma' => $row['dh_ma'],
        // Sử dụng hàm number_format(số tiền, số lẻ thập phân, dấu phân cách số lẻ, dấu phân cách hàng nghìn) để định dạng số khi hiển thị trên giao diện. Vd: 15800000 -> format thành 15,800,000.66 vnđ
        'sp_dh_soluong' => number_format($row['sp_dh_soluong'], 2, ".", ","),
        'sp_dh_dongia' => number_format($row['sp_dh_dongia'], 2, ".", ","),

        // Các cột dữ liệu lấy từ liên kết khóa ngoại
        'sp_ma' => $row['sp_ma'],
        'dh_ma' => $row['dh_ma'],

    );
}
// var_dump($data);die;
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/index.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `ds_sanpham`
echo $twig->render('backend/sanpham_dondathang/index.html.twig', ['ds_sanpham_dondathang' => $data] );