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
    <title>Danh sách các loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Danh sách các loài hoa</h1>
        <div class="row mt-4">
            <?php foreach ($flowers as $flower): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?= $flower['image'] ?>" class="card-img-top" alt="<?= $flower['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $flower['name'] ?></h5>
                            <p class="card-text"><?= $flower['description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
