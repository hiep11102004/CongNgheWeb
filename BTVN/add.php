<?php
$dbname = "qlsp";
$servername = "localhost"; 
$username = "root";        
$password = "";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];

  $sql = "INSERT INTO sanpham (name, price) VALUES ('$name', '$price')";

  if ($conn->query($sql) === TRUE) {
      echo "Sản phẩm đã được thêm thành công.";
      header("Location: index.php");
      exit(); 
  } else {
      echo "Lỗi khi thêm sản phẩm: " . $conn->error;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="text-center">
        <h1>Thêm sản phẩm</h1>
    </div>

    <div class="container" style="width: 70%;margin-top:50px">
        <form action="add.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name">
                <label for="floatingInput">Sản phẩm</label>
              </div>
              <div class="form-floating">
                <input type="text" class="form-control" name="price">
                <label for="floatingPassword">Giá Thành</label>
              </div>
              <button style="margin-top:50px" type="submit" class="btn btn-success">Gửi</button>
        </form>
        
    </div>
</body>
</html>