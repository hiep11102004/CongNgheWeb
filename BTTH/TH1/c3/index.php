<?php
$filename = "student.csv";

$sinhvien = [];

if (($handle = fopen($filename, "r")) !== FALSE) {
    $headers = fgetcsv($handle, 1000, ",");

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sinhvien[] = array_combine($headers, $data);
    }

    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-wrapper {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table-title {
            color: #fff;
            background-color: #007bff;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="table-wrapper">
            <div class="table-title">
                <h1>Danh sách sinh viên</h1>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Lớp</th>
                        <th>Điểm trung bình</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sinhvien as $sv) {
                        echo "<tr>";
                        echo "<td>{$sv['ID']}</td>";
                        echo "<td>{$sv['Họ tên']}</td>";
                        echo "<td>{$sv['Ngày sinh']}</td>";
                        echo "<td>{$sv['Lớp']}</td>";
                        echo "<td>{$sv['Điểm trung bình']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

