<?php
include 'db.php';

$sql = "SELECT * FROM flowers";
$result = $conn->query($sql);
$flowers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flowers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Quản lý loài hoa</h1>
        <a href="add.php" class="btn btn-primary">Thêm hoa mới</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên hoa</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flowers as $flower): ?>
                    <tr>
                        <td><?= $flower['id'] ?></td>
                        <td><?= $flower['name'] ?></td>
                        <td><?= $flower['description'] ?></td>
                        <td><img src="<?= $flower['image'] ?>" alt="<?= $flower['name'] ?>" width="100"></td>
                        <td>
                            <a href="edit.php?id=<?= $flower['id'] ?>" class="btn btn-warning">Sửa</a>
                            <a href="delete.php?id=<?= $flower['id'] ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
