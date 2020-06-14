<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

// 2. Chuẩn bị câu truy vấn $sql
// $stt=1;
$sql = "select * from `khachhang`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sql);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $kh_ngaythangnamsinh = '';
    if(!empty($row['kh_ngaysinh'])) {
        // Sử dụng hàm sprintf() để chuẩn bị mẫu câu với các giá trị truyền vào tương ứng từng vị trí placeholder
        $kh_ngaythangnamsinh = sprintf(" %s/%s/%s", 
            $row['kh_ngaysinh'],
            $row['kh_thangsinh'],
            $row['kh_namsinh']
            );  //vd: '2019-05-10'
    }
    $data[] = array(
        'kh_tendangnhap' => $row['kh_tendangnhap'],
        'kh_matkhau' => $row['kh_matkhau'],
        'kh_ten' => $row['kh_ten'],
        'kh_gioitinh' => $row['kh_gioitinh'],
        'kh_diachi' => $row['kh_diachi'],
        'kh_dienthoai' => $row['kh_dienthoai'],
        'kh_email' => $row['kh_email'],
        'kh_ngaythangnamsinh' => $kh_ngaythangnamsinh,
        'kh_cmnd' => $row['kh_cmnd'],
        'kh_makichhoat' => $row['kh_makichhoat'],
        'kh_trangthai' => $row['kh_trangthai'],
        'kh_quantri' => $row['kh_quantri'],
    );
}
// var_dump($data);die;
// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/loaisanpham.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `ds_loaisanpham`
echo $twig->render('backend/khachhang/index.html.twig', ['ds_khachhang' => $data] );