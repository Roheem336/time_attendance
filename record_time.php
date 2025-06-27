<?php
require("connect.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$action = $_POST['action'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO time_logs (user_id, action_type) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $action);
$stmt->execute();

header("Location: dashboard.php");
