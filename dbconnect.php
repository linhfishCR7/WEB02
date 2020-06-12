    <?php
    $conn=mysqli_connect('localhost','root','','salomon') or die('Không thể kết nối dữ liệu');
    require_once __DIR__.'/bootstrap.php';
    $conn->query("SET NAME 'utf8'");
    $conn->query("SET CHARACTER SET UTF8");
    $conn->query("SET SESSION collation_connection='utf8_general_ci'");
    ?>
