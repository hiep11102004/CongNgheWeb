<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = 'hoadep/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image);

  
    $sql = "INSERT INTO flowers (name, description, image) VALUES ('$name', '$description', '$image')";
    if ($conn->query($sql)) {
        header('Location: admin.php'); 
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm loài hoa mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Thêm loài hoa mới</h1>
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên hoa</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm hoa</button>
        </form>
    </div>
</body>
</html>
