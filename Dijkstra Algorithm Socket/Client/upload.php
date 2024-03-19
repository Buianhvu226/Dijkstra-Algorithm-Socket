<?php
session_start();
if (isset($_SESSION['username'])) {
    $name = $_SESSION['username'];
    echo
        '<div style="text-align: right; font-family: Arial, sans-serif; margin-top: 20px; margin-right: 20px;">
            <span style="color: #333; font-weight: bold;">Xin chào</span>, 
            <span style="color: #45a049; font-style: italic; font-size: 22px">' . $name . '</span>
            <form action="../User/logout.php" method="post" style="display: inline-block; margin-left: 10px;"> 
                <input type="submit" value="Đăng xuất" style="padding: 8px 15px; background-color: #5091C7; color: white; border: none; cursor: pointer; border-radius: 4px;"> 
            </form>
        </div>';
} else {
    header("Location: ../User/login.php");
}

$host = "192.168.184.30";
$port = 12345;

// Tạo socket client
$clientSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($clientSocket, $host, $port);

// Đọc file từ form và gửi nó đến server
if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK && $_SERVER["REQUEST_METHOD"] == "POST") {

    $beginVertex = $_POST['beginVertex'];
    $temp = (int) $beginVertex;
    $fileContent = file_get_contents($_FILES['fileToUpload']['tmp_name']);

    // Tạo ma trận đồ thị từ dữ liệu trong file
    $dataArray = preg_split('/\s+/', $fileContent, -1, PREG_SPLIT_NO_EMPTY);

    $totalElements = count($dataArray);

    $squareRoot = sqrt($totalElements);
    $rowCount = (int) $squareRoot;

    if ($temp > $rowCount) {
        echo ('Đỉnh nhập không tồn tại!');
        socket_close($clientSocket);
    }
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

    // Ghép dữ liệu điểm bắt đầu và ma trận đồ thị để gửi lên server
    $data = $beginVertex . "--" . $processedData;

    // Gửi dữ liệu lên server thông qua socket
    socket_write($clientSocket, $data, strlen($data));

    $response = socket_read($clientSocket, 1024);
    //echo $response;
    include_once('ClientResult.php');

} else {
    echo "File upload failed!";
}

// Đóng socket
socket_close($clientSocket);
?>