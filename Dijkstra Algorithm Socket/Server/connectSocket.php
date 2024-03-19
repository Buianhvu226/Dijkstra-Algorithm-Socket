<!DOCTYPE html>
<html>
<head>
    <title>TÌNH TRẠNG</title>
    <style>

        body {
            background-color: #F0FFF0;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container-server {
            width: 80%;
            margin: 50px auto;
            text-align: center;
            background-color: #FFE4E1;
            padding: 20px;
            border: 1px solid red;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        h1 {
            color: #333;
        }
        .server-info {
            font-size: 18px;
            margin-top: 20px;
        }
        .server-port {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-server">
        <h1>TÌNH TRẠNG KẾT NỐI CỦA SERVER</h1>
        <div class="server-info">
            <?php
            
            echo "Server đang chạy trên cổng: <span class='server-port'>$host:$port</span>";
            
            ?>
        </div>
    </div>
</body>
</html>
