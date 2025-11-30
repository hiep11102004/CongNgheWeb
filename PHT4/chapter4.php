<?php
$host = '127.0.0.1';
$dbname = 'cse485_web';
$username = 'root'; 
$password = ''; 
$dsn = "mysql:host=localhost;dbname=cse485_web;charset=utf8"; 


try {
    $pdo = new PDO($dsn, $username, $password);
    // Thiết lập chế độ lỗi của PDO thành Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    exit();
}

if(isset($_POST['ten_sinh_vien']) && isset($_POST['email'])){
    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (:ten_sinh_vien, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ten_sinh_vien' => $ten,
        ':email' => $email
    ]);

    header("Location: chapter4.php");
    exit();
}


$sql_select = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";
$stmt_select = $pdo->query($sql_select);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 4 - Website hướng dữ liệu</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Thêm Sinh Viên Mới (Chủ đề 4.3)</h2>
    <form action="chapter4.php" method="POST">
        Tên sinh viên: <input type="text" name="ten_sinh_vien" required>
        Email: <input type="email" name="email" required>
        <button type="submit">Thêm</button>
    </form>
    <h2>Danh Sách Sinh Viên (Chủ đề 4.2)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên Sinh Viên</th>
            <th>Email</th>
            <th>Ngày Tạo</th>
        </tr>
        <?php
            while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ten_sinh_vien']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ngay_tao']) . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>


