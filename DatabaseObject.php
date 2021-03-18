<?php

/**
 * DatabaseObject.php
 * DatabaseObject to handle managing database connection and queries
 */

class DatabaseObject {

    private $con;

    public function __construct($host, $username, $password, $database) {
            try {
                $this->con = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }


    }
    public function register($username, $password, $email, $number) {
        $trn_date = date("Y-m-d");
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $password_hash = substr( $password_hash, 0, 60 );

        try{
        $sth = $this->con->prepare("SELECT * FROM users WHERE username= '$username' ");
        $sth->execute(array(':username'=>$username));

        $count = $sth->rowCount();
        if($count  == 1){
            throw new Exception ('The name is already taken!');
        }
        $sth = $this->con->prepare( "INSERT INTO users (username, password, email, phonenumber, Create_At) VALUES ('$username', '$password_hash', '$email', '$number', '$trn_date') ");
        $sth->execute();
        echo "Account created!";


        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

    public function login($username, $password) {

        try{

            $sth = $this->con->prepare("SELECT * FROM users WHERE username='$username' OR email='$username'");
            $sth->execute();
            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if($sth->rowCount() < 0){
                throw new Exception ('Login or email is incorrect!');
            }

            if($username==$row["username"] or $username=$row["email"]){
                if(password_verify($password, $row["password"])){

                    $_SESSION["user_id"] = $row["id"];
                    header("refresh:2; chat");

                }else{
                    print_r($password);
                    throw new Exception ('Password is incorrect!');
                }
            }else{
                throw new Exception ('Login or email is incorrect!');
            }




        }catch (Exception $e){
            echo $e->getMessage();
        }

    }


}
