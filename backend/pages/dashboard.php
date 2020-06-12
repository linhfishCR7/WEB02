<?php
    include_once(__DIR__.'/../../dbconnect.php');
    $sql= <<<AOT
        SELECT*
        FROM `hinhthucthanhtoan`
AOT;

$result=mysqli_query($conn,$sql);


$data = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = array(
            'MaThanhToan' => $row['httt_ma'],
            'TenThanhToan' => $row['httt_ten'],
        );
    }

    // Yêu cầu `Twig` vẽ giao diện được viết trong file `vidu1.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `products`
echo $twig->render('backend/pages/dashboard.html.twig', ['httt' => $data] );
?>