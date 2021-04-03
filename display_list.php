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

#get user info 
$username=$_SESSION['username'];

$sql = "SELECT role FROM persons WHERE email=?";
$query=$pdo->prepare($sql);
$query->execute(Array($_SESSION['username']));
$result = $query->fetch(PDO::FETCH_ASSOC);
$role = implode("", $result);

#Display User Info
echo "<h2>Logged in as: ".$username."</h2>";
echo "<p>Permission status: ".$role."</p>";
echo "<a style='color: orange;' href='logout.php'>Logout</a>";

# display link to "create" form
echo "<h1>Persons List</h1>";

echo "<a href='register.php'>Create</a><br><br> ";



# display all records
$ctr= 1;
$sql = 'SELECT * FROM persons';
echo "<style>
table,
th,
td {
    padding:10px;
    border: 1px solid black;
    border-collapse: collapse;
}
</style>";

echo "<table>
<tr>
<th>Options</th>
<th>Role</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
"/*<th>Phone #</th>
<th>Address 1</th>
<th>Address 2</th>
<th>City</th>
<th>State</th>
<th>Zip Code</th>
</tr>"*/;

foreach ($pdo->query($sql) as $row) {
	
    $str = "<tr>";
    if($role=="user"){
        $str .= "<td><a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";
        if($row['email']==$username){
            $str .= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
        }
        $str .= "</td>";
    }
    else{
        $str .= "<td><a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";
	    $str .= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
	    $str .= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a></td> ";
    }
    $str .="<td>". $row['role'] . "</td>";
    $str .="<td>". $row['fname'] . "</td>";
    $str .="<td>". $row['lname'] . "</td>";
    $str .="<td>". $row['email'] . "</td>";
    //$str .="<td>". $row['phone'] . "</td>";
    //$str .="<td>". $row['address'] . "</td>";
    //$str .="<td>". $row['address2'] . "</td>";
    //$str .="<td>". $row['city'] . "</td>";
    //$str .="<td>". $row['state'] . "</td>";
    //$str .="<td>". $row['zip_code'] . "</td>";
    $str .= "</tr>";
    echo $str;
    
    /*$str = "";
	$str .= "<a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";
	$str .= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
	$str .= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a> ";
    $str .= "(" . $ctr . "): " . $row['fname'] ." ". $row['lname'];
	$str .=  '<br>';
	echo $str;
	$ctr++;*/
}
echo "</table>";
echo '<br />';
