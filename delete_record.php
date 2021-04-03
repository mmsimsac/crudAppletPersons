<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
include_once "header.php";
# 1. connect to database
require '../database2/database.php';
$pdo = Database::connect();

# 2. assign user info to a variable
$id = $_GET['id'];
//$m = htmlspecialchars($m);

# 3. assign MySQL query code to a variable
$sql = "DELETE FROM persons WHERE id = ?";
$query =$pdo->prepare($sql);
$query->execute(Array($id));

echo "<p>Your info has been deleted</p><br>";
echo "<a href='display_list.php'>Back to list</a>";