<?php
require_once 'db.php';

$role = $_GET['role'] ?? 'guest';

$sql = "SELECT id, name, description, image FROM flowers ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

$flowers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $flowers[] = $row;
    }
    mysqli_free_result($result);
}

if ($role === 'admin') {
    // Thêm hoa mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['action'])
        && $_POST['action'] === 'add'
    ) {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');

        if ($name !== '' && $description !== '' && $image !== '') {
            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO flowers (name, description, image) VALUES (?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, 'sss', $name, $description, $image);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: ?role=admin');
        exit;
    }

    // Xóa hoa
    if (isset($_GET['delete_id'])) {
        $id = (int) $_GET['delete_id'];
        if ($id > 0) {
            $stmt = mysqli_prepare($conn, "DELETE FROM flowers WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: ?role=admin');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách các loài hoa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<h1>Danh sách các loài hoa xuân – hè</h1>
<div>
    Vai trò:
    <a href="?role=guest" style="font-weight:<?php echo $role === 'guest' ? 'bold' : 'normal'; ?>">Khách</a> |
    <a href="?role=admin" style="font-weight:<?php echo $role === 'admin' ? 'bold' : 'normal'; ?>">Quản trị</a>
</div>


<div>
<?php if ($role === 'guest'): ?>
    <h2>Gợi ý các loài hoa nên trồng dịp xuân – hè</h2>
    <?php if (empty($flowers)): ?>
        <p>Hiện chưa có dữ liệu hoa trong CSDL.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($flowers as $flower): ?>
            <li style="margin-bottom:12px;">
                <b><?php echo htmlspecialchars($flower['name']); ?></b><br>
                <img src="images/<?php echo htmlspecialchars($flower['image']); ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" style="width:120px;max-height:90px;"><br>
                <span><?php echo nl2br(htmlspecialchars($flower['description'])); ?></span>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php else: ?>
    <h2>Quản lý danh sách hoa</h2>
    <form method="post" style="margin-bottom:16px;">
        <input type="hidden" name="action" value="add">
        Tên hoa: <input type="text" name="name" required>
        Mô tả: <input type="text" name="description" required>
        Tên file ảnh: <input type="text" name="image" placeholder="vd: hoa_hong.jpg" required>
        <button type="submit">Thêm hoa</button>
    </form>
    <?php if (empty($flowers)): ?>
        <p>Hiện chưa có dữ liệu hoa trong CSDL.</p>
    <?php else: ?>
        <table border="1" cellpadding="6" style="border-collapse:collapse;">
            <tr>
                <th>#</th>
                <th>Tên hoa</th>
                <th>Mô tả</th>
                <th>Ảnh</th>
                <th>Xóa</th>
            </tr>
            <?php foreach ($flowers as $index => $flower): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($flower['name']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($flower['description'])); ?></td>
                <td><img src="images/<?php echo htmlspecialchars($flower['image']); ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" style="width:80px;max-height:60px;"><br><?php echo htmlspecialchars($flower['image']); ?></td>
                <td><a href="?role=admin&delete_id=<?php echo $flower['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>
</div>

</body>
</html>
