<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
include_once "header.php";
# This process updates a record. There is no display.

# 1. connect to database
require '../database2/database.php';
$pdo = Database::connect();

# 2. assign user info to a variable
$username = $_POST['username'];
//$password = $_POST['password'];
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
//$password = htmlspecialchars($password);
$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$phone = htmlspecialchars($phone);
$address = htmlspecialchars($address);
$address2 = htmlspecialchars($address2);
$city = htmlspecialchars($city);
$state = htmlspecialchars($state);
$zip_code = htmlspecialchars($zip_code);

//$password_hash = MD5($password);
//$password_salt = MD5(microtime());

$id = $_GET['id'];

$sql = "SELECT role FROM persons WHERE id=?";
$query=$pdo->prepare($sql);
$query->execute(Array($id));
$result = $query->fetch(PDO::FETCH_ASSOC);
$roleOld = implode("", $result);
$urlID="&id=".$id;

if($roleOld=="user"){
    $role="user";
}
if(empty($username)||empty($role)||empty($fname)||empty($lname)||empty($phone)||empty($address)||empty($city)||empty($state)||empty($zip_code)){
    header("Location:display_update_form.php?error=empty".$urlID);
}
else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $username)) {
    header("Location:display_update_form.php?error=invalidEmail".$urlID);
}
else {
    # 3. assign MySQL query code to a variable
    $sql = "UPDATE persons SET email=?, role=?, fname=?, lname=?, phone=?, `address`=?, address2=?, city=?, `state`=?, zip_code=? WHERE id=?";

    $query=$pdo->prepare($sql);
    $query->execute(Array($username, $role, $fname, $lname, $phone, $address, $address2, $city, $state, $zip_code, $id));

    # 4. insert the message into the database
    try{
        $pdo->query($sql); # execute the query
        echo "<p>Your info has been added. You can now log in.</p><br>";
        echo "<a href='display_list'>Go Back</a>";
    }
    catch(Exception $e){
        echo "<a href='display_list.php'>Go Back</a>";
    }
}
/*# 4. update the message in the database
$pdo->query($sql); # execute the query
echo "<p>Your info has been added</p><br>";
echo "<a href='display_list.php'>Back to list</a>";*/