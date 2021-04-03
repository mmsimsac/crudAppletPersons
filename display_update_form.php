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
<h1>Update existing person</h1>
<?php
error_reporting(0);
if($_GET['error']=='empty')
    echo "<p style='color:red'>Missing Required Fields</p></br>";
else if($_GET['error']=='invalidEmail')
    echo "<p style='color:red'>Invalid email</p></br>";
?>
<form method='post' action='update_record.php?id=<?php echo $id ?>'>
    <p>
    Email: <input name='username' type='text' value='<?php echo $result['email']; ?>' ><txt style='color:red'>*</txt><br />
    Role: <select name="role" >
        <option value="user" selected>user</option>
        <option value="admin">admin</option>
        </select><br />
    First Name: <input name='fname' type='text' value='<?php echo $result['fname']; ?>'><txt style='color:red'>*</txt><br />
    Last Name: <input name='lname' type='text' value='<?php echo $result['lname']; ?>'><txt style='color:red'>*</txt><br />
    Phone: <input name='phone' type='text' value='<?php echo $result['phone']; ?>'><txt style='color:red'>*</txt><br />
    Address: <input name='address' type='text'value='<?php echo $result['address']; ?>' ><txt style='color:red'>*</txt><br />
    Address2: <input name='address2' type='text' value='<?php echo $result['address2']; ?>'><br />
    City: <input name='city' type='text' value='<?php echo $result['city']; ?>'><txt style='color:red'>*</txt><br />
    State: <input name='state' type='text' value='<?php echo $result['state']; ?>'><txt style='color:red'>*</txt><br />
    Zip: <input name='zip_code' type='text' value='<?php echo $result['zip_code']; ?>'><txt style='color:red'>*</txt><br />
    <br>
    </p>
    <input type="submit" value="Submit">
</form>
<form method='post' action='display_list.php'>
<input type="submit" value="Go Back">
