<?php require("connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper">
    <form method="post">
        <h1>Forgot Password</h1>
        <div class="input-box">
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-box">
            <input type="password" name="new_password" placeholder="New password" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
        <div class="register-link">
            <a href="login.php">Back to Login</a>
        </div>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // ตรวจสอบว่ามี username นี้หรือไม่
    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // ถ้ามี username ให้ update password ใหม่
        $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update->bind_param("ss", $new_password, $username);
        if ($update->execute()) {
            echo "<p style='color:green;'>เปลี่ยนรหัสผ่านเรียบร้อย <a href='login.php'>Login</a></p>";
        } else {
            echo "<p style='color:red;'>เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน</p>";
        }
    } else {
        echo "<p style='color:red;'>ไม่พบผู้ใช้นี้</p>";
    }
}
?>
</body>
</html>
