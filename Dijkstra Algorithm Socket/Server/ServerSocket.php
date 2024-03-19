<?php
include_once('Server-Algo.php');


$host = "192.168.184.30";
$port = 12345;

$context = stream_context_create([
    'socket' => [
        'so_reuseport' => true,
        'backlog' => 2048,
        'so_reuseaddr' => true,
        'so_keepalive' => true,
        'so_linger' => 1,
        'so_bindtodevice' => ''

    ],
]);

$serverSocket = stream_socket_server("tcp://$host:$port", $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);
if (!$serverSocket) {
    die("Error: $errstr ($errno)");
}

include('connectSocket.php');
echo ("<br><br><br>");


$clients = [];
$lastDataReceivedTime = time();
$clientCount = 0;

while (true) {
    $readSockets = $clients;
    $readSockets[] = $serverSocket;

    if (stream_select($readSockets, $write, $except, 20) > 0) {
        foreach ($readSockets as $key => $clientSocket) {
            if ($clientSocket === $serverSocket) {
                $newClient = stream_socket_accept($serverSocket);
                $clients[] = $newClient;

                $clientCount++;
                $clientNumber = str_pad($clientCount, 2, '0', STR_PAD_LEFT);
                include('ClientConnected.php');
                continue;
            }

            $dataFromClient = fread($clientSocket, 1024);
            if ($dataFromClient === false || feof($clientSocket)) {
                fclose($clientSocket);
                unset($clients[$key]);
                continue;
            }

            // Xử lý dữ liệu từ client...
            $dataArray = explode("--", $dataFromClient);
            $beginVertex = (int) $dataArray[0];
            $matrixData = $dataArray[1];

            $rows = explode("<br><br>", $matrixData);
            $graph = [];
            foreach ($rows as $row) {
                $rowArray = explode(" ", $row);
                $graph[] = $rowArray;
            }

            include('Server.php');
            echo ("<br><br>");
            include('line.php');
            echo ("<br><br><br>");

            // Chạy thuật toán Dijkstra
            $result = dijkstra($graph, $beginVertex);
            $distances = $result[0];
            $previousVertices = $result[1];

            $returnRS = "";
            // Hiển thị các khoảng cách tính bằng thuật toán Dijkstra
            $returnRS .= "<b>Đường đi ngắn nhất và khoảng cách từ đỉnh $beginVertex đến các đỉnh còn lại là:</b><br><br>";
            for ($i = 0; $i < count($distances); $i++) {
                if ($i !== $beginVertex) {
                    $path = getPath($beginVertex, $i, $previousVertices);
                    $returnRS .= "Đỉnh " . implode(' ---> Đỉnh ', $path) . ": <strong>" . $distances[$i] . "</strong><br><br>";
                }
            }

            // Gửi kết quả trở lại cho client
            fwrite($clientSocket, $returnRS, strlen($returnRS));
            fclose($clientSocket);
            $key = array_search($clientSocket, $clients);
            unset($clients[$key]);

            // Cập nhật thời gian nhận dữ liệu cuối cùng
            $lastDataReceivedTime = time();
        }
    }

    // Kiểm tra thời gian kể từ lần cuối cùng nhận dữ liệu từ Client
    if (time() - $lastDataReceivedTime >= 20) {
        include('warning.php');
        break;
    }
}

fclose($serverSocket);
?>