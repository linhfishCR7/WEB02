<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

use Dompdf\Dompdf;

/* --- 
   --- 2. Truy vấn dữ liệu Sản phẩm theo khóa chính
   --- 
*/
// Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$dh_ma = $_GET['dh_ma'];

$sqlSelectDonDatHang = <<<EOT
SELECT 
    ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai
    , SUM(spddh.sp_dh_quantity * spddh.sp_dh_dongia) AS Tongamount
FROM `dondathang` ddh
JOIN `sanpham_dondathang` spddh ON ddh.dh_ma = spddh.dh_ma
JOIN `khachhang` kh ON ddh.kh_tendangnhap = kh.kh_tendangnhap
JOIN `hinhthucthanhtoan` httt ON ddh.httt_ma = httt.httt_ma
WHERE ddh.dh_ma=$dh_ma
GROUP BY ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai
EOT;

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record
$resultSelectDonDatHang = mysqli_query($conn, $sqlSelectDonDatHang);
$dondathangRow;
while($row = mysqli_fetch_array($resultSelectDonDatHang, MYSQLI_ASSOC))
{
    $dondathangRow = array(
        'dh_ma' => $row['dh_ma'],
        'dh_ngaylap' => date('d/m/Y H:i:s', strtotime($row['dh_ngaylap'])),
        'dh_ngaygiao' => empty($row['dh_ngaygiao']) ? '' : date('d/m/Y H:i:s', strtotime($row['dh_ngaygiao'])),
        'dh_noigiao' => $row['dh_noigiao'],
        'dh_trangthaithanhtoan' => $row['dh_trangthaithanhtoan'],
        'httt_ten' => $row['httt_ten'],
        'kh_ten' => $row['kh_ten'],
        'kh_dienthoai' => $row['kh_dienthoai'],
        'Tongamount' => number_format($row['Tongamount'], 2, ".", ",") . ' vnđ',
    );
}

// Lấy dữ liệu Sản phẩm đơn đặt hàng
$sqlSelectSanPham = <<<EOT
SELECT 
    sp.product_name, spddh.sp_dh_dongia, spddh.sp_dh_quantity
    , lsp.lproduct_name, nsx.nsx_ten
FROM `sanpham_dondathang` spddh
JOIN `sanpham` sp ON spddh.sp_ma = sp.sp_ma
JOIN `loaisanpham` lsp ON sp.lsp_ma = lsp.lsp_ma
JOIN `nhasanxuat` nsx ON sp.nsx_ma = nsx.nsx_ma
WHERE spddh.dh_ma=$dh_ma
EOT;

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelectSanPham = mysqli_query($conn, $sqlSelectSanPham);
$dataSanPham = [];
while($row = mysqli_fetch_array($resultSelectSanPham, MYSQLI_ASSOC))
{
    $dataSanPham[] = array(
        'product_name' => $row['product_name'],
        'sp_gia' => $row['sp_dh_dongia'],
        'sp_quantity' => $row['sp_dh_quantity'],
        'lproduct_name' => $row['lproduct_name'],
        'nsx_ten' => $row['nsx_ten'],
    );
}

// Hiệu chỉnh dữ liệu theo cấu trúc để tiện xử lý
$dondathangRow['danhsachsanpham'] = $dataSanPham;
//dd($dondathangRow);

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/dondathang/pdf.html.twig`
$html = $twig->render('backend/dondathang/pdf.html.twig', [
    'dondathang' => $dondathangRow,
]);

// Khởi tạo Dompdf
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->loadHtml($html);

// Set trang giấy A4
$dompdf->setPaper('A4', 'portrait');

// Render giao diện file PDF
$dompdf->render();

// Xuất thành file cho người dùng download
$dompdf->stream();