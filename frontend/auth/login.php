<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__ . '/../../bootstrap.php';
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../../dbconnect.php');
if(isset($_SESSION['email_logged']) && !empty($_SESSION['email_logged'])) {
    echo 'Bạn đã đăng nhập rồi. <a href="/frontend/index.php">Bấm vào đây để quay về trang chủ.</a>';
}else{
if(isset($_POST['btnLogin'])) {
    // Kiểm tra đăng nhập...
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    // Câu lệnh SELECT
    $sqlSelect = <<<EOT
    SELECT *
    FROM khachhang kh
    WHERE kh.kh_email = '$email' AND kh.kh_matkhau = '$password';
EOT;
    // Thực thi SELECT
    $result = mysqli_query($conn, $sqlSelect);
    // Sử dụng hàm `mysqli_num_rows()` để đếm số dòng SELECT được
    // Nếu có bất kỳ dòng dữ liệu nào SELECT được <-> Người dùng có tồn tại và đã đúng thông tin USERNAME, PASSWORD
    if (mysqli_num_rows($result) > 0) {
        echo 'Đăng nhập thành công!';
        // redirect đi đâu đó...
        header("location:/frontend/index.php");

        $_SESSION['email_logged'] = $email;
        
    } else {
        echo 'Đăng nhập thất bại!';
    }
} else {
    echo $twig->render('frontend/auth/login.html.twig');
}
}
?>