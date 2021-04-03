<?php
//error_reporting(0);
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
include_once "header.php";
# connect
require '../database2/database.php';
$pdo = Database::connect();

# put the information for the chosen record into variable $results 
$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id=" . $id;
$query=$pdo->prepare($sql);
$query->execute();
$result = $query->fetch();

?>
<style>table, th, td {
    padding:10px;
    border: 1px solid black;
    border-collapse: collapse;
}</style>
<h1>Read/view existing person</h1>
<form method='post' action='display_list.php'>
    <table>
        <tr>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone #</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>City</th>
            <th>State</th>
            <th>Zip Code</th>
        </tr>
        <tr>
            <td><?php echo $result['role']; ?></td>
            <td><?php echo $result['fname']; ?></td>
            <td><?php echo $result['lname']; ?></td>
            <td><?php echo $result['email']; ?></td>
            <td><?php echo $result['phone']; ?></td>
            <td><?php echo $result['address']; ?></td>
            <td><?php echo $result['address2']; ?></td>
            <td><?php echo $result['city']; ?></td>
            <td><?php echo $result['state']; ?></td>
            <td><?php echo $result['zip_code']; ?></td>
        </tr>
    </table>
    <br>       
    <input type="submit" value="Go Back">
</form>