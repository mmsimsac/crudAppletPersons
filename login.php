<?php
include_once "header.php";
    session_start();
    $errMsg='';
    if (isset($_POST['login'])
        && !empty($_POST['username'])
        && !empty($_POST['password'])){
            
        $_POST['username']= htmlspecialchars($_POST['username']);
        $_POST['password']= htmlspecialchars($_POST['password']);
        
        if ($_POST['username'] == 'admin123@admin.com'
            && $_POST['password'] == 'admin123'){
            
            $_SESSION['username']='admin123@admin.com';    
            
            header("Location: display_list.php");
        }
        else{
            require '../database2/database.php';
            $pdo = Database::connect();
            $hash=$_POST['password'];
            $hash=MD5($hash);
            $sql = "SELECT * FROM persons " . " WHERE email=? " . "AND password_hash=? " . " LIMIT 1";
            $query=$pdo->prepare($sql);
            $query->execute(Array($_POST['username'], $hash));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result){
                $_SESSION['username'] = $result['email'];
                header('Location: display_list.php');
            }
            else{
                $errMsg='Login Failure : Wrong Username or Password';
            }
        }
    }
    
//print_r($_SESSION)
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Persons Crud Applet with Login</title>
        <meta charset="utf-8" />
    </head>
    
    <body>
        <h1>Persons Crud Applet with Login</h1>
        <h2>Login</h2>
        
        <form action ="" method="post">
            
            <input type="text" class="form-control"
                name="username" placeholder="Email"
                required autofocus />  <br />
            <input type="password" class="form-control"
                name="password" placeholder="Password" required /><br />
            <button class="btn btn-lg btn-primary btn-block"    
                type="submit" name="login">Login</button>
            
            <button class="btn btn-lg btn-secondary btn-block"   
                onclick="window.location.href = 'register.php';";
                type="submit" name="join">Join</button>    
                
            <p style="color: red;"><?php echo $errMsg; ?></p>    
        </form>
        <br>
        <a href='https://github.com/mmsimsac/crudAppletPersons' style="text-align:center"><h2><i>Github Repo</i><h2></a>
    </body>
    
</html>