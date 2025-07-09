<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    // ถ้าผู้ใช้ login แล้ว แต่ย้อนกลับมาหน้านี้ → redirect กลับ Dashboard ทันที
    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit();
}

require("connect.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?v=3">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
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
    <div class="box"></div>
    <div class="wrapper">
        <form method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" required>
                <i class=""></i> <!--bx bxs-user-->
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class=""></i> <!--bx bxs-lock-alt-->
            </div>
            <div class="remember-forgot">
                <label for="">
                    <input type="checkbox">
                    Remamber me
                </label>
                <a href="forgot_password.php">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>
                    Don't have an account.
                    <a href="signup.php">Register</a>
                </p>
            </div>
        </form>
    </div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute(); $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($_POST['password']== $row['password']) {   //(password_verify($_POST['password'], $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
        } else echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาด",
            text: "รหัสผ่านไม่ถูกต้อง!",
            confirmButtonText: "ลองใหม่"
        }).then(() => {
            window.history.back(); // กลับไปหน้าเดิม
        });
    </script>
';
    } else echo "ไม่พบชื่อผู้ใช้";
}

?>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        window.location.href = 'login.php'; // หรือหน้าอื่นตามต้องการ
    };
</script>

</body>
</html>
