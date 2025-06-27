<?php require("connect.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/board.css">
    <title>Dashboard</title>
</head>
<body>
    <h1>ยินดีต้อนรับ</h1>
    <a href="logout.php">ออกจากระบบ</a>

    <form method="post" action="record_time.php">
        <button name="action" value="IN">ลงเวลาเข้า</button>
        <button name="action" value="OUT">ลงเวลาออก</button>
    </form>

    <h3>ประวัติการลงเวลา</h3>
    <table table border="1">
        <tr>
            <th>ประเภท</th>
            <th>เวลา</th>
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
</body>
</html>
