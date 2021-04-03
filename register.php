<h1>Register New User</h1>
<?php
error_reporting(0);
include_once "header.php";
if($_GET['error']=='empty')
    echo "<p style='color:red'>Missing Required Fields</p></br>";
else if($_GET['error']=='invalidEmail')
    echo "<p style='color:red'>Invalid email</p></br>";
else if($_GET['error']=='passwordError')
    echo "<p style='color:red'>Password must include a special character, a capital letter, a number, and be of length greater than 8</p></br>";
?>
<style>
p{
    text-align:left;
    line-height: 1.8;
}
h1{
    padding-left: 100px;;
}
</style>
<form method='post' action='register_new_user.php'>
    <p>
    Email: <input name='username' type='text' value=<?php echo $_GET['username'] ?>><txt style='color:red'>*</txt><br />
    Password: <input name='password' type='password' ><txt style='color:red'>*</txt><br />
    Role: <select name="role" >
        <option value="user" <?php if($_GET['role']=='user')  echo 'selected'; ?>>user</option>
        <option value="admin" <?php if($_GET['role']=='admin')  echo 'selected'; ?>>admin</option>
        </select><br />
    First Name: <input name='fname' type='text' value=<?php echo $_GET['fname'] ?>><txt style='color:red'>*</txt><br />
    Last Name: <input name='lname' type='text' value=<?php echo $_GET['lname'] ?>><txt style='color:red'>*</txt><br />
    Phone: <input name='phone' type='text' value=<?php echo $_GET['phone'] ?>><txt style='color:red'>*</txt><br />
    Address: <input name='address' type='text' value=<?php echo $_GET['address'] ?>><txt style='color:red'>*</txt><br />
    Address2: <input name='address2' type='text' value=<?php echo $_GET['address2'] ?>><br />
    City: <input name='city' type='text' value=<?php echo $_GET['city'] ?>><txt style='color:red'>*</txt><br />
    State: <input name='state' type='text' value=<?php echo $_GET['state'] ?>><txt style='color:red'>*</txt><br />
    Zip: <input name='zip_code' type='text' value=<?php echo $_GET['zip_code'] ?>><txt style='color:red'>*</txt><br />
    </p>
    <input type="submit" value="Submit">
</form>