<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// 2. Chuẩn bị câu truy vấn $sql
// Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
$sql = <<<EOT
SELECT COUNT(gybl.gy_bl_ma) AS sogopy, gybl.gy_bl_noidung ,bl.*
FROM `blog` bl
JOIN `gopy_blog` gybl ON gybl.bl_ma=bl.bl_ma
JOIN `khachhang` kh ON bl.kh_ma=kh.kh_ma
JOIN `loaisanpham` lsp ON bl.lsp_ma=lsp.lsp_ma

EOT;

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sql);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
   

    $data[] = array(
        'bl_ma' => $row['bl_ma'],
        'bl_hinhanh' => $row['bl_hinhanh'],
        'bl_chude' => $row['bl_chude'],
        'bl_ngay' => date('d/m/Y H:i:s', strtotime($row['bl_ngay'])),
        'bl_noidung' => $row['bl_noidung'],
        'bl_mota_ngan' => $row['bl_mota_ngan'],
        'bl_tags' => $row['bl_tags'],
        'lsp_ma' => $row['lsp_ma'],
        'kh_ma' => $row['kh_ma'],
        'gy_bl_noidung' => $row['gy_bl_noidung'],
        'sogopy' => $row['sogopy'],
    );
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/hinhsanpham/index.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `ds_hinhsanpham`
echo $twig->render('backend/blog/index.html.twig', ['ds_blog' => $data] );