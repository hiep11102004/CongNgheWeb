<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

  
    $sql = "SELECT * FROM flowers WHERE id = $id";
    $result = $conn->query($sql);
    $flower = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'] ? 'images/' . basename($_FILES['image']['name']) : $flower['image'];

    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }


    $sql = "UPDATE flowers SET name = '$name', description = '$description', image = '$image' WHERE id = $id";
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
    <title>Sửa loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Sửa loài hoa</h1>
        <form action="edit.php?id=<?= $flower['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên hoa</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $flower['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" required><?= $flower['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control">
                <img src="<?= $flower['image'] ?>" alt="<?= $flower['name'] ?>" width="100">
            </div>
            <button type="submit" class="btn btn-success">Cập nhật hoa</button>
        </form>
    </div>
</body>
</html>
