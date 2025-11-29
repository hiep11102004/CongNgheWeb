<?php
// Đường dẫn tới file CSV
$filename = __DIR__ . '/65HTTT_Danh_sach_diem_danh.csv';

if (!file_exists($filename)) {
    die('Không tìm thấy 65HTTT_Danh_sach_diem_danh.csv');
}

$rows = [];
$headers = [];

// Mở file
if (($handle = fopen($filename, 'r')) !== false) {

    // Đọc dòng đầu làm header
    if (($data = fgetcsv($handle, 0, ',')) !== false) {   // nếu dùng ; thì đổi ',' thành ';'
        $headers = $data;
    }

    // Đọc các dòng còn lại
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        // Bỏ qua dòng trống hoàn toàn
        if (count(array_filter($data, fn($v) => $v !== '')) === 0) {
            continue;
        }
        $rows[] = $data;
    }

    fclose($handle);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 03 - Đọc tệp CSV</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="margin-bottom: 16px;">Bài 03: Đọc tệp tin CSV</h2>

<?php if (empty($headers)): ?>
    <p><b>Không đọc được tiêu đề từ file CSV.</b></p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 700px; margin-bottom: 20px;">
        <thead style="background: #f0f0f0;">
            <tr>
                <?php foreach ($headers as $h): ?>
                    <th><?php echo htmlspecialchars($h); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="<?php echo count($headers); ?>" style="text-align:center; color: #888; font-style: italic;">Không có dữ liệu.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
