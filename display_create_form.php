<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
include_once "header.php";
require '../database2/database.php';
$pdo = Database::connect();

# 2. assign user info to a variable
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$username = htmlspecialchars($username);
$password = htmlspecialchars($password);
$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$phone = htmlspecialchars($phone);
$address = htmlspecialchars($address);
$address2 = htmlspecialchars($address2);
$city = htmlspecialchars($city);
$state = htmlspecialchars($state);
$zip_code = htmlspecialchars($zip_code);

$password_hash = MD5($password);
$password_salt = MD5(microtime());

$sql = "SELECT id FROM persons WHERE email=?";
$query=$pdo->prepare($sql);
$query->execute(Array($username));
$result = $query->fetch(PDO::FETCH_ASSOC);

if($result){
    echo "<p>Email $username already exists.</p><br>";
    echo "<a href='register.php'>Try Again</a>";
}
else{
    # 3. assign MySQL query code to a variable
    $sql = "INSERT INTO persons (email, password_hash, password_salt, role, fname, lname, phone, address, address2, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $query=$pdo->prepare($sql);
    $query->execute(Array($username, $password_hash, $password_salt, $role, $fname, $lname, $phone, $address, $address2, $city, $state, $zip_code));

    # 4. insert the message into the database
    try{
        $pdo->query($sql); # execute the query
        echo "<p>Your info has been added. You can now log in.</p><br>";
        echo "<a href='login.php'>Back to login</a>";
    }
    catch(Exception $e){
        echo "<a href='login.php'>Back to login</a>";
    }
}
?>    