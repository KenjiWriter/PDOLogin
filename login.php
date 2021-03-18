<?php
session_start();
include('DatabaseObject.php');
include('DatabaseVars.php');

$database = new DatabaseObject($host, $username, $password, $database);
    if(!empty($_POST['login'])){
        $username = strip_tags($_REQUEST['username']);
        $password = $_REQUEST['password'];

    try{
        if(empty($username)){
            throw new Exception ('Enter username!');
        }

        if(empty($password)){
            throw new Exception ('Enter password!');
        }

        $database->login($username, $password);

        }catch (Exception $e) {
        echo $e->getMessage();
        }
    }

?>

<form action="" method="POST">
    <?php if(!empty($error)){echo '<p  style="color: #ff0000;">' .$error.'</p>';} ?>
    <label style='width: 6em;'>Username/E-mail:</label> <input type='text' name="username" /> <br />
    <label style='width: 6em;'>Password:</label> <input type='password' name="password" /> <br />
    <input type="submit" name="login" value="Login" /><br> <a href="./">New on the site? Click to register</a>
</form><br> <br>
