<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F0FFF0;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #4CAF50;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .result {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #fff;
            transition: transform 0.3s ease-in-out;
        }

        .result p {
            margin: 10px 0;
            color: #666;
        }

        /* Hover effect */
        .result:hover {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            display: block;
            text-align: center;
            margin: 20px auto;
            width: 100px;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #F0FFF0;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .back-btn:hover {
            background-color: #FFFACD;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>KẾT QUẢ NHẬN ĐƯỢC</h1>

        <div class="result">
            <?php
            echo $response;
            ?>
        </div>

        <a href="javascript:history.go(-1);" class="back-btn">Quay lại</a>
    </div>
</body>

</html>