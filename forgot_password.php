<?php 
require("connect.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css?v=3">
    <style>
    body {
      opacity: 0;
      animation: fadeIn 1s forwards;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
    </style>
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
            <p>
                Remember your password?
                <a href="login.php">Back to Login</a>
            </p>
        </div>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $new_password = $_POST['new_password']; //password_hash($_POST['new_password'], PASSWORD_DEFAULT);

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
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                        icon: "success",
                        title: "เปลี่ยนรหัสผ่านเรียบร้อย",
                        text: "คลิก OK เพื่อไปหน้า Login",
                        confirmButtonText: "ไปหน้า Login"
                        }).then(() => {
                         window.location.href = "login.php";
                        });
                    </script>
                  ';             //echo "<p style='color:green;'>เปลี่ยนรหัสผ่านเรียบร้อย <a href='login.php'>Login</a></p>";
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
