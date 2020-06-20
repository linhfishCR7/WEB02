<?php

// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
    

 
$sqlnsx = "select * from `nhasanxuat`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultnsx = mysqli_query($conn, $sqlnsx);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datansx = [];
while($row = mysqli_fetch_array($resultnsx, MYSQLI_ASSOC))
{
    $datansx[] = array(
        'nsx_ma' => $row['nsx_ma'],
        'nsx_ten' => $row['nsx_ten'],

    );
}

$sqlnsxcount = "select count(nhasanxuat.nsx_ma) as nsx_soluong from `nhasanxuat`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultnsxcount = mysqli_query($conn, $sqlnsxcount);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datansxcount = [];
while($row = mysqli_fetch_array($resultnsxcount, MYSQLI_ASSOC))
{
    $datansxcount[] = array(
       
        'nsx_soluong' => number_format($row['nsx_soluong'], 0, ".", ","),

    );
}

$sqllsp = "select * from `loaisanpham`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultlsp = mysqli_query($conn, $sqllsp);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datalsp = [];
while($row = mysqli_fetch_array($resultlsp, MYSQLI_ASSOC))
{
    $datalsp[] = array(
        'lsp_ma' => $row['lsp_ma'],
        'lsp_ten' => $row['lsp_ten'],
        'lsp_mota' => $row['lsp_mota'],
    );
}

$sqllspcount = "select count(loaisanpham.lsp_ma) as lsp_soluong from `loaisanpham`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultlspcount = mysqli_query($conn, $sqllspcount);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datalspcount = [];
while($row = mysqli_fetch_array($resultlspcount, MYSQLI_ASSOC))
{
    $datalspcount[] = array(
        'lsp_soluong' => number_format($row['lsp_soluong'], 0, ".", ","),

    );
}

$sqlkh = "select * from `khachhang`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultkh = mysqli_query($conn, $sqlkh);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datakh = [];
while($row = mysqli_fetch_array($resultkh, MYSQLI_ASSOC))
{
    $datakh[] = array(
        'kh_ma' => $row['kh_ma'],
        'kh_ten' => $row['kh_ten'],
        'kh_email' => $row['kh_email'],
    );
}

$sqlkhcount = "select count(khachhang.kh_ma) as kh_soluong from `khachhang`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultkhcount = mysqli_query($conn, $sqlkhcount);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datakhcount = [];
while($row = mysqli_fetch_array($resultkhcount, MYSQLI_ASSOC))
{
    $datakhcount[] = array(
        'kh_soluong' => number_format($row['kh_soluong'], 0, ".", ","),

    );
}

$sqlcdgy = "select * from `chudegopy`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultcdgy = mysqli_query($conn, $sqlcdgy);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datacdgy = [];
while($row = mysqli_fetch_array($resultcdgy, MYSQLI_ASSOC))
{
    $datacdgy[] = array(
        'cdgy_ma' => $row['cdgy_ma'],
        'cdgy_ten' => $row['cdgy_ten'],
    );
}

$sqlcdgycount = "select count(chudegopy.cdgy_ma) as cdgy_soluong from `chudegopy`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resultcdgycount = mysqli_query($conn, $sqlcdgycount);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datacdgycount = [];
while($row = mysqli_fetch_array($resultcdgycount, MYSQLI_ASSOC))
{
    $datacdgycount[] = array(
        'cdgy_soluong' => number_format($row['cdgy_soluong'], 0, ".", ","),

    );
}

$sqlhsp = "select hinhsanpham.hsp_tentaptin from `hinhsanpham`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resulthsp = mysqli_query($conn, $sqlhsp);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datahsp = [];
while($row = mysqli_fetch_array($resulthsp, MYSQLI_ASSOC))
{
    $datahsp[] = array(
        'hsp_tentaptin' => $row['hsp_tentaptin'],
        
    );
}

// var_dump($datahsp);die;
$sqlhspcount = "select count(hinhsanpham.hsp_ma) as hsp_soluong from `hinhsanpham`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$resulthspcount = mysqli_query($conn, $sqlhspcount);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về
$datahspcount = [];
while($row = mysqli_fetch_array($resulthspcount, MYSQLI_ASSOC))
{
    $datahspcount[] = array(
        'hsp_soluong' => number_format($row['hsp_soluong'], 0, ".", ","),

    );
}


// var_dump($datansxcount);die;
    // Yêu cầu `Twig` vẽ giao diện được viết trong file `vidu1.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `products`
echo $twig->render('backend/pages/dashboard.html.twig', [
'ds_nhasanxuat' => $datansx,
'ds_nhasanxuatcount' => $datansxcount,
'ds_loaisanpham'=>$datalsp,
'ds_loaisanphamcount'=>$datalspcount,
'ds_khachhang'=>$datakh,
'ds_khachhangcount'=>$datakhcount,
'ds_chudegopy'=>$datacdgy,
'ds_chudegopycount'=>$datacdgycount,
'ds_hinhsanpham'=>$datahsp,
'ds_hinhsanphamcount'=>$datahspcount] );
?>