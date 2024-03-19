<?php
session_start();
if (isset($_SESSION['username'])) {
    $name = $_SESSION['username'];
} else {
    header("Location: ../User/login.php");
}

$host = "192.168.184.30";  // Địa chỉ IP của máy chủ
$port = 12345;        // Cổng kết nối

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $beginVertex = $_POST["beginVertex"];
    $matrixData = $_POST["matrixTextArea"];

    // Tạo socket khách hàng
    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    if ($socket === false) {
        echo "Không thể tạo socket: " . socket_strerror(socket_last_error()) . "<br>";
    }

    // Kết nối đến máy chủ
    if (socket_connect($socket, $host, $port) === false) {
        echo "Không thể kết nối đến máy chủ: " . socket_strerror(socket_last_error()) . "<br>";
    }

    // Tách dữ liệu thành mảng dựa trên khoảng trắng hoặc dấu cách
    $dataArray = preg_split('/\s+/', $matrixData, -1, PREG_SPLIT_NO_EMPTY);

    $totalElements = count($dataArray);


    $squareRoot = sqrt($totalElements);

    $rowCount = (int) $squareRoot;
    $colCount = $rowCount;

        $processedData = "";
        for ($i = 0; $i < $rowCount; $i++) {
            for ($j = 0; $j < $colCount; $j++) {
                $index = $i * $colCount + $j;
                if ($index < $totalElements) {
                    $processedData .= $dataArray[$index] . " ";
                }
            }
            $processedData .= "<br><br>";
        }

        $data = $beginVertex . "--" . $processedData; // Ghép dữ liệu điểm bắt đầu và ma trận đồ thị
        socket_write($socket, $data, strlen($data));

        // Đọc phản hồi từ máy chủ
        $response = socket_read($socket, 1024);

    //echo $response;
    include_once('ClientResult.php');

    // Đóng kết nối
    socket_close($socket);
}
?>