<?php require("connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?v=4">
    <title>Sign Up</title>
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
            <h1>Sign Up</h1>
            <div class="input-box">
                <input type="text" placeholder="Fullname" name="fullname" required>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" required>
                <i class="bx bxs-user"></i> 
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <button class="btn" type="submit">Sign Up</button>
            <div class="register-link">
                <p>
                    Already have an account?
                    <a href="login.php">Login</a>
                </p>
            </div>
        </form>
    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password']; //password_hash($_POST['password'], PASSWORD_DEFAULT);(อันนี้ก็ได้)

    $stmt = $conn->prepare("INSERT INTO users (fullname, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $username, $password);
    if ($stmt->execute()) {
        die(header('Location: login.php')); //echo "สมัครสำเร็จ <a href='login.php'>Login</a>";(อันนี้ก็ได้)
        
    } else {
        echo "Username ซ้ำหรือผิดพลาด";
    }
}
?>
</body>
</html>
