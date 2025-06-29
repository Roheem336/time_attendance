<?php 
session_start();
require("connect.php");
if (!isset($_SESSION['user_id'])) {
    // ถ้ายังไม่ login → redirect กลับหน้า login
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/board.css?v=15">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Dashboard</title>
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
    <h1>Welcome</h1>
    
    <a href="logout.php">Logout
      <i class="bx bx-lock-alt"></i>
    </a>

    <form method="post" action="record_time.php">
        <button name="action" value="IN">
          Clock in
          <i class="bx bx-check"></i>
        </button>
        <button name="action" value="OUT">
          Clock out
          <i class="bx bx-check"></i>
        </button>
    </form>

    <h3>History <i class="bx bx-history"></i></h3>
    <table table border="1">
        <tr>
            <th>Type</th>
            <th>Time <i class="bx bx-time"></i></th>
        </tr>

<?php
$sql = "SELECT action_type, log_time FROM time_logs WHERE user_id=? ORDER BY log_time DESC LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute(); $result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['action_type']}</td><td>{$row['log_time']}</td></tr>";
}
?>
</table>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        window.location.href = 'dashboard.php'; // หรือหน้าอื่นตามต้องการ
    };
</script>

</body>
</html>
