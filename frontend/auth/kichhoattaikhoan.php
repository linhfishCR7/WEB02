<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
// Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST GET
$kh_tendangnhap = $_GET['kh_tendangnhap'];
$kh_makichhoat = $_GET['kh_makichhoat'];
// Câu lệnh SELECT
$sqlSelect = <<<EOT
    SELECT *
    FROM khachhang
    WHERE kh_tendangnhap = '$kh_tendangnhap'
    LIMIT 1;
EOT;
// Thực thi SELECT
$result = mysqli_query($conn, $sqlSelect) or die("<b>Có lỗi khi thực thi câu lệnh SQL: </b>" . mysqli_error($conn) . "<br /><b>Câu lệnh vừa thực thi:</b></br>$sqlSelect");
// Sử dụng hàm `mysqli_num_rows()` để đếm số dòng SELECT được
// Nếu có bất kỳ dòng dữ liệu nào SELECT được <-> Người dùng có tồn tại và đã đúng thông tin kh_tendangnhap, kh_makichhoat
if(mysqli_num_rows($result) > 0) {
    // Cập nhật trạng thái của User này thành 1 (kích hoạt)
    $sqlUpdate = <<<EOT
        UPDATE khachhang
        SET kh_trangthai = 1
        WHERE kh_tendangnhap = '$kh_tendangnhap' AND kh_makichhoat = '$kh_makichhoat';
EOT;
    // Thực thi SELECT
    mysqli_query($conn, $sqlUpdate) or die("<b>Có lỗi khi thực thi câu lệnh SQL: </b>" . mysqli_error($conn) . "<br /><b>Câu lệnh vừa thực thi:</b></br>$sqlUpdate");
    // Kiểm tra xem có dòng nào được cập nhật hay không?
    if($conn->affected_rows > 0) {
        // Yêu cầu `Twig` vẽ giao diện được viết trong file `frontend/auth/user-activated.html.twig`
        echo $twig->render('frontend/auth/user-activated.html.twig');
    } else {
        echo 'Không tìm thấy tài khoản cần Cập nhật!';
    }
}
else {
    echo 'Không tìm thấy người dùng. Kích hoạt thất bại!';
}