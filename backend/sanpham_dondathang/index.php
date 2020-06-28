<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// 2. Chuẩn bị câu truy vấn $sql
// Sử dụng HEREDOC của PHP để tạo câu truy vấn SQL với dạng dễ đọc, thân thiện với việc bảo trì code
$sql = <<<EOT
    SELECT dh.*
        , httt.httt_ten
        , kh.kh_ten
    FROM `dondathang` dh
    JOIN `hinhthucthanhtoan` httt ON dh.httt_ma = httt.httt_ma
    JOIN `khachhang` kh ON dh.kh_ma = kh.kh_ma
    ORDER BY dh.dh_ma DESC
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
        'dh_ma' => $row['dh_ma'],
        'dh_ngaylap' => date('d/m/Y H:i:s', strtotime($row['dh_ngaylap'])),
        // Sử dụng hàm number_format(số tiền, số lẻ thập phân, dấu phân cách số lẻ, dấu phân cách hàng nghìn) để định dạng số khi hiển thị trên giao diện. Vd: 15800000 -> format thành 15,800,000.66 vnđ
        'dh_ngaygiao' => date('d/m/Y H:i:s', strtotime($row['dh_ngaygiao'])),
        'dh_noigiao' => $row['dh_noigiao'],
        'dh_trangthaithanhtoan' => number_format($row['dh_trangthaithanhtoan'], 0, ".", ","),
        'httt_ma' => $row['httt_ma'],
        'kh_ma' => $row['kh_ma'],
        // Các cột dữ liệu lấy từ liên kết khóa ngoại
        'httt_ten' => $row['httt_ten'],
        'kh_ten' => $row['kh_ten'],

    );
}
// var_dump($data);die;
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/sanpham/index.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `ds_sanpham`
echo $twig->render('backend/dondathang/index.html.twig', ['ds_dondathang' => $data] );