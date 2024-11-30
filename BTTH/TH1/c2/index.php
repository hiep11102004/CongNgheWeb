<?php

$servername = "localhost";
$username = "root";  
$password = "";      
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS quiz";
if ($conn->query($sql) === TRUE) {
    echo "Cơ sở dữ liệu 'quiz' đã được tạo thành công.\n";
} else {
    echo "Lỗi khi tạo cơ sở dữ liệu: " . $conn->error;
}

$conn->select_db("quiz");

$sql = "CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    option_a TEXT NOT NULL,
    option_b TEXT NOT NULL,
    option_c TEXT NOT NULL,
    option_d TEXT NOT NULL,
    correct_answer CHAR(1) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'questions' đã được tạo thành công.\n";
} else {
    echo "Lỗi khi tạo bảng: " . $conn->error;
}

$conn->close();
?>
<?php
$filename = "question.txt";
$questions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$answers = [];
$current_question = [];
foreach ($questions as $line) {
    if (strpos($line, "Câu") === 0) {
        if (!empty($current_question)) {
            if (isset($current_question[5])) {
                $answers[] = trim(substr($current_question[5], strpos($current_question[5], ":") + 1));
            }
        }
        $current_question = [];
    }
    $current_question[] = $line;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Trắc Nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .question-header {
            background-color: #007bff;
            color: white;
        }
        .accordion-button:not(.collapsed) {
            color: #fff;
            background-color: #0d6efd;
        }
        .btn-submit {
            background-color: #007bff;
            border: none;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Bài Trắc Nghiệm</h2>
        <form method="post" action="result.php">
            <div class="accordion" id="quizAccordion">
                <?php
                $current_question = [];
                foreach ($questions as $index => $question) {
                    if (strpos($question, "Câu") === 0) {
                        $current_question = [];
                        $current_question[] = $question;
                        $current_question[] = $questions[$index + 1];
                        $current_question[] = $questions[$index + 2];
                        $current_question[] = $questions[$index + 3];
                        $current_question[] = $questions[$index + 4];
                        $current_question[] = $questions[$index + 5];

                        echo "<div class='accordion-item'>";
                        echo "<h2 class='accordion-header' id='heading{$index}'>";
                        echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse{$index}' aria-expanded='false' aria-controls='collapse{$index}'>";
                        echo "{$current_question[0]}";
                        echo "</button>";
                        echo "</h2>";
                        echo "<div id='collapse{$index}' class='accordion-collapse collapse' aria-labelledby='heading{$index}' data-bs-parent='#quizAccordion'>";
                        echo "<div class='accordion-body'>";
                        
                        for ($i = 1; $i <= 4; $i++) {
                            $answer = substr($current_question[$i], 0, 1);
                            echo "<div class='form-check mb-2'>";
                            echo "<input class='form-check-input' type='radio' name='question{$index}' value='{$answer}' id='question{$index}{$answer}'>";
                            echo "<label class='form-check-label' for='question{$index}{$answer}'>{$current_question[$i]}</label>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-submit btn-lg">Nộp bài</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

