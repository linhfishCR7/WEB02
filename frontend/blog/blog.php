<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__ . '/../../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../../dbconnect.php');

//danh sách blog

$sqlDanhSachBlog = <<<EOT
SELECT bl.*, MAX(hb.hb_tentaptin) AS hb_tentaptin,COUNT(gybl.gy_bl_ma) AS sogopy
    FROM `blog` bl
LEFT JOIN `hinhblog` hb ON bl.bl_ma = hb.bl_ma
JOIN `loaisanpham` lsp ON bl.lsp_ma = lsp.lsp_ma
JOIN `khachhang` kh ON bl.kh_ma= kh.kh_ma
JOIN `gopy_blog` gybl ON bl.bl_ma= gybl.bl_ma
GROUP BY bl.bl_ma, bl.bl_chude, bl.bl_mota_ngan, bl.bl_ngay,bl.bl_tags,lsp.lsp_ma,kh.kh_ma
EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sqlDanhSachBlog);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachBlog = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $dataDanhSachBlog[] = array(
        'bl_ma' => $row['bl_ma'],
        'bl_chude' => $row['bl_chude'],
        'bl_mota_ngan' => $row['bl_mota_ngan'] ,
        'bl_noidung' => $row['bl_noidung'],
        'bl_ngay' => date('M d,Y', strtotime($row['bl_ngay'])),
        'bl_tags' => $row['bl_tags'],
        'lsp_ma' => $row['lsp_ma'],
        'kh_ma' => $row['kh_ma'],
        'hb_tentaptin' => $row['hb_tentaptin'],
        'sogopy' => $row['sogopy']

    );
}

//recent news
$sqlNew = <<<EOT
SELECT bl.*, MAX(hb.hb_tentaptin) AS hb_tentaptin,COUNT(gybl.gy_bl_ma) AS sogopy
    FROM `blog` bl
LEFT JOIN `hinhblog` hb ON bl.bl_ma = hb.bl_ma
JOIN `loaisanpham` lsp ON bl.lsp_ma = lsp.lsp_ma
JOIN `khachhang` kh ON bl.kh_ma= kh.kh_ma
JOIN `gopy_blog` gybl ON bl.bl_ma= gybl.bl_ma
GROUP BY bl.bl_ma, bl.bl_chude, bl.bl_mota_ngan, bl.bl_ngay,bl.bl_tags,lsp.lsp_ma,kh.kh_ma
ORDER BY bl.bl_ngay DESC
EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sqlNew);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataNew = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $dataNew[] = array(
        'bl_ma' => $row['bl_ma'],
        'bl_chude' => $row['bl_chude'],
        'bl_ngay' => date('M d,Y', strtotime($row['bl_ngay'])),
        'hb_tentaptin' => $row['hb_tentaptin'],

    );
}

echo $twig->render('frontend/blog/blog.html.twig', [
    'danhsachBlog' => $dataDanhSachBlog,
    'New' => $dataNew

    
]);
