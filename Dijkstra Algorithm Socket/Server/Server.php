<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Server</title>

    <style>


        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .result {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #4CAF50;
        }

        .vertex {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .graph-matrix {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 6px;
        }

        .graph-matrix p {
            margin: 0;
            font-family: monospace;

        }
    </style>
</head>

<body>
    <div class="container">

        <div class="result">
         <h1 class="text-center">DỮ LIỆU NHẬN ĐƯỢC TỪ CLIENT</h1>

            <p class="vertex">Đỉnh bắt đầu: <?php echo $beginVertex; ?></p>
            <div class="graph-matrix">
                <?php
                echo '<b>Ma trận đồ thị nhận được:</b><br><br>';
                $rows = explode("<br><br>", $matrixData);
                foreach ($rows as $row) {
                    echo "<p>$row</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
