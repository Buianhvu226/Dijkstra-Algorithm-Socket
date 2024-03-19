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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phép toán định đường phân tán</title>
    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <header>

        <h1>PHÉP TOÁN ĐỊNH ĐƯỜNG PHÂN TÁN</h1>
    </header>
    <main>
        <div id="left-panel">
            <div id="top-panel">

                <div id="graph-browsing">
                    <h2>Dữ liệu của đồ thị</h2>
                    <form action="ClientSocket.php" method="post">
                        <label for="beginVertex">Điểm bắt đầu :</label>
                        <input type="text" id="beginVertex" name="beginVertex" placeholder="Nhập điểm bắt đầu...">

                        <div id="matrix">
                            <h2>Ma trận</h2>
                            <textarea id="matrixTextArea" name="matrixTextArea" readonly></textarea>
                        </div>

                        <input class="SendBtn" type="submit" value="Gửi dữ liệu" style="width: 180px;
                   height: 50px;
                   color: darkgreen;
                   padding: 10px;
                   border-radius: 50px;
                   font-size: large;
                   font-family: Arial, Helvetica, sans-serif">

                    </form>
                </div>
            </div>
            <div id="center-panel">
                <div id="function">
                    <div id="edge-vertex">
                        <h2>Đỉnh và cạnh</h2>
                        <label for="firstPoint">Điểm đầu:</label>
                        <input type="text" id="firstPoint" name="firstPoint" placeholder="Nhập điểm đầu">
                        <label for="finalPoint">Điểm cuối:</label>
                        <input type="text" id="finalPoint" name="finalPoint" placeholder="Nhập điểm cuối">
                        <label for="weight">Trọng số đường đi:</label>
                        <input type="text" id="weight" name="weight" placeholder="Nhập trọng số">
                        <label for="nameVertex">Tên cạnh:</label>
                        <input type="text" id="nameVertex" name="nameVertex" placeholder="Nhập tên cạnh">
                    </div>
                    <div id="function-buttons">
                        <h2>Lựa chọn chức năng</h2>
                        <button id="addEdgeBtn">Thêm cạnh</button>
                        <button id="deleteEdgeBtn">Xóa cạnh</button>
                        <button id="deleteVertexBtn">Xóa đỉnh</button>
                        <button id="newBtn">Làm mới</button>
                        <a href="File.php">
                            <button>Nhập File</button>
                        </a>

                    </div>

                    <div id="edgeTableContainer">
                        <h2>Các cạnh đã tồn tại:</h2>
                        <table id="edgeTable"></table>
                    </div>

                    <h2>Ma trận</h2>

                    <h3><i>*Chú thích:</i></h3>

                    <p>
                        - <strong><em>W</em></strong> : Trọng số của cạnh.
                        <br />
                        - <strong><em>N</em></strong> : Tên của cạnh.
                    </p>


                </div>
            </div>

        </div>
    </main>

    <!-- Cuối cùng, import script.js để chứa mã JavaScript chính -->
    <script src="../scriptPbl.js"></script>

</body>

</html>