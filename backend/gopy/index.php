<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// 2. Chuẩn bị câu truy vấn $sql
// Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
$sql = <<<EOT
    SELECT *
    FROM `gopy` gy
    JOIN `chudegopy` cdgy on gy.cdgy_ma = cdgy.cdgy_ma
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
        'gy_ma' => $row['gy_ma'],
        'gy_hoten' => $row['gy_hoten'],
        'gy_email' => $row['gy_email'],
        'gy_diachi' => $row['gy_diachi'],
        'gy_dienthoai' => $row['gy_dienthoai'],
        'gy_tieude' => $row['gy_tieude'],
        'gy_noidung' => $row['gy_noidung'],
        'gy_ngaygopy' => date('d/m/Y H:i:s', strtotime($row['gy_ngaygopy'])),
        'cdgy_ma' => $row['cdgy_ma'],
    );
}
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/hinhsanpham/index.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `ds_hinhsanpham`
echo $twig->render('backend/gopy/index.html.twig', ['ds_gopy' => $data] );