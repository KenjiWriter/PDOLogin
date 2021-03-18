<?php

include('DatabaseObject.php');
include('DatabaseVars.php');

$database = new DatabaseObject($host, $username, $password, $database);

if(!empty($_POST['register'])){
    $username = strip_tags($_REQUEST['username']);
    $password = strip_tags($_REQUEST['password']);
    $email = strip_tags($_REQUEST['email']);
    $number = (int)($_REQUEST['number']);

    try{
        //Username
        if(empty($username)){
            throw new Exception ('Enter username!');
        }

        if(empty($password)){
            throw new Exception ('Enter password!');
        }

        if (strlen($username) < 5) {
            throw new Exception ('Username must be at least 5 characters!');
        }

        if (strlen($email) < 5) {
            throw new Exception ('Username must be at least 5 characters!');
        }
        if ($number <= 10) {
            throw new Exception ('Insert a correct phone number!');
        }

        if (strlen($username) > 16) {
            throw new Exception ('Username must be shorter than 16 characters!');
        }
        if(strlen($password) < 5){
            throw new Exception ('Password must be at least 5 characters!');
        }

        if (!ctype_alnum($username)) {
            throw new Exception ('Username must be only letters and numbers!');
        }

        $database->register($username, $password, $email, $number);

    }catch (Exception $e){
        echo $e->getMessage();
    }
}

?>

<form action="" method="POST">
    <?php if(!empty($error)){echo '<p  style="color: #ff0000;">' .$error.'</p>';} ?>
    <label style='width: 6em;'>Username:</label> <input type='text' name="username" /> <br />
    <label style='width: 6em;'>Password:</label> <input type='password' name="password" /> <br />
    <label style='width: 6em;'>E-mail:</label> <input type='text' name="email" /> <br />
    <label style='width: 6em;'>Phone number:</label> <input type='number' name="number" /> <br />
    <input type="submit" name="register" value="create account" /><br> <a href="login">Already registered? Click to login</a>
</form><br> <br>

