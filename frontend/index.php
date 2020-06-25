<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../bootstrap.php';
// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../dbconnect.php');
// 2. Chuẩn bị câu truy vấn $sql
// HEREDOC
$sqlDanhSachSanPham = <<<EOT
    SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota_ngan, sp.sp_soluong, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
    FROM `sanpham` sp
    JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
    LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
    GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota_ngan, sp.sp_soluong, lsp.lsp_ten

EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sqlDanhSachSanPham);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPham = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $dataDanhSachSanPham[] = array(
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
        'sp_giacu' => number_format($row['sp_giacu'], 2, ".", ","),
        'sp_mota_ngan' => $row['sp_mota_ngan'],
        'sp_soluong' => $row['sp_soluong'],
        'lsp_ten' => $row['lsp_ten'],
        'hsp_tentaptin' => $row['hsp_tentaptin'],
    );
}
// top lasest product

$sqlDanhSachSanPhamLastest = <<<EOT
        SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
        FROM `sanpham` sp
        JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
        LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten
        ORDER BY sp.sp_ma ASC
        LIMIT  3

EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDanhSachSanPhamLastest = mysqli_query($conn, $sqlDanhSachSanPhamLastest);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPhamLastest = [];
while($row = mysqli_fetch_array($resultDanhSachSanPhamLastest, MYSQLI_ASSOC))
{
    $dataDanhSachSanPhamLastest[] = array(
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
        'lsp_ten' => $row['lsp_ten'],
        'hsp_tentaptin' => $row['hsp_tentaptin'],
    );
}

$sqlDanhSachSanPhamTopRate = <<<EOT
        SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
        FROM `sanpham` sp
        JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
        LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten
        ORDER BY sp.sp_gia desc
        LIMIT  3

EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDanhSachSanPhamTopRate = mysqli_query($conn, $sqlDanhSachSanPhamTopRate);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPhamTopRate = [];
while($row = mysqli_fetch_array($resultDanhSachSanPhamTopRate, MYSQLI_ASSOC))
{
    $dataDanhSachSanPhamTopRate[] = array(
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
        'lsp_ten' => $row['lsp_ten'],
        'hsp_tentaptin' => $row['hsp_tentaptin'],
    );
}

$sqlDanhSachSanPhamReview = <<<EOT
        SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
        FROM `sanpham` sp
        JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
        LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten
        ORDER BY sp.sp_ma DESC
        LIMIT  3

EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDanhSachSanPhamReview = mysqli_query($conn, $sqlDanhSachSanPhamReview);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPhamReview = [];
while($row = mysqli_fetch_array($resultDanhSachSanPhamReview, MYSQLI_ASSOC))
{
    $dataDanhSachSanPhamReview[] = array(
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
        'lsp_ten' => $row['lsp_ten'],
        'hsp_tentaptin' => $row['hsp_tentaptin'],
    );
}

$sqlDanhSachSanPhamCarousel= <<<EOT
        SELECT sp.sp_ma, sp.sp_ten, lsp.lsp_ten, MAX(hsp.hsp_tentaptin) AS hsp_tentaptin
        FROM `sanpham` sp
        JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
        LEFT JOIN `hinhsanpham` hsp ON sp.sp_ma = hsp.sp_ma
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, lsp.lsp_ten


EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDanhSachSanPhamCarousel = mysqli_query($conn, $sqlDanhSachSanPhamCarousel);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPhamCarousel = [];
while($row = mysqli_fetch_array($resultDanhSachSanPhamCarousel, MYSQLI_ASSOC))
{
    $dataDanhSachSanPhamCarousel[] = array(
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'lsp_ten' => $row['lsp_ten'],
        'hsp_tentaptin' => $row['hsp_tentaptin'],
    );
}

$sqlDanhSachSanPhamDanhMuc= <<<EOT
        SELECT distinct  lsp.lsp_ten
        FROM `loaisanpham` lsp



EOT;
// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultDanhSachSanPhamDanhMuc = mysqli_query($conn, $sqlDanhSachSanPhamDanhMuc);
// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$dataDanhSachSanPhamDanhMuc = [];
while($row = mysqli_fetch_array($resultDanhSachSanPhamDanhMuc, MYSQLI_ASSOC))
{
    $dataDanhSachSanPhamDanhMuc[] = array(
        'lsp_ten' => $row['lsp_ten'],
    );
}
// var_dump($dataDanhSachSanPhamLastest);die;
// print_r($dataDanhSachSanPham);die;
// Yêu cầu `Twig` vẽ giao diện được viết trong file `frontend/pages/home.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên
echo $twig->render('frontend/pages/home.html.twig', [
    'danhsachsanpham' => $dataDanhSachSanPham, 
    'danhsachsanphamLastest' => $dataDanhSachSanPhamLastest,
    'danhsachsanphamTopRate' => $dataDanhSachSanPhamTopRate,
    'danhsachsanphamReview' => $dataDanhSachSanPhamReview,
    'danhsachsanphamCarousel' => $dataDanhSachSanPhamCarousel,
    'danhsachsanphamDanhMuc' => $dataDanhSachSanPhamDanhMuc
]);
?>