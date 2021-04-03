<?php
error_reporting(0);
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


$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

$url = "&email=" . $username ."&role=" . $role ."&fname=" . $fname ."&lname=" . $lname ."&phone=" . $phone ."&address=" . $address ."&address2=" . $address2 ."&city=" . $city ."&state=" . $state ."&zip_code=" . $zip_code;



if(empty($username)||empty($password)||empty($role)||empty($fname)||empty($lname)||empty($phone)||empty($address)||empty($city)||empty($state)||empty($zip_code)){
    header("Location:register.php?error=empty".$url);
}
else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $username)) {
    header("Location:register.php?error=invalidEmail".$url);
}
else if (!$uppercase || !$number || !$lowercase || !$specialChars || strlen($password) < 8){
    header("Location:register.php?error=passwordError".$url);
}
else{
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
             echo "<a href='display_list'>Go Back</a>";
        }
        catch(Exception $e){
            echo "<a href='display_list.php'>Go Back</a>";
        }
    }
}
?>    