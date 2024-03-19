<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["username"];
    $pass = $_POST["password"];

    $result = accept($name, $pass);

    $_SESSION['login_result'] = $result;
    $_SESSION['username'] = $name;
    $_SESSION['id'];

    header("Location: login.php");
    exit();
}

function accept($name, $pass)
{
    $link = mysqli_connect("localhost", "root", "")
        or die('Không thể kết nối đến cơ sở dữ liệu');
    mysqli_select_db($link, "pbl4");

    $sql = "SELECT * FROM users WHERE username = '$name' AND password = '$pass'";

    $result = mysqli_query($link, $sql);

    // Đóng kết nối đến cơ sở dữ liệu
    mysqli_close($link);

    // Chuyển kết quả thành mảng để trả về
    $resultArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $resultArray[] = $row;
    }

    return $resultArray;
}
?>