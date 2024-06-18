<?php
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["username"];
    $email = $_POST["email"];
    $cnum = $_POST["cnum"];
    $pass = $_POST["pass"];
    $passwordhash=password_hash($pass,PASSWORD_DEFAULT);
    
    require_once "components/database.php";
    $sql =  "INSERT INTO signup (username,email,contact_num,password) VALUES( ?, ?, ?, ? )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss",$name,$email,$cnum,$passwordhash);
  
    if($stmt->execute()){
      header("Location: index.php");
      //echo"sucess";
    }else{
      echo"Error" . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
  }
 
  
  ?>