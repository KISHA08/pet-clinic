
<?php
session_start();

if(isset($_POST['submit'])){
   $admin_id = "Niththa"; 
   $password = "8888"; 
   
   $id = $_POST['name'];
   $pass = $_POST['pass'];

   if ($admin_id === $id && $password === $pass) {
      $_SESSION["admin_id"] = $id; 
      header("Location: dashboard.php");
      exit();
   } else {
      echo "error";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="Stylesheet" href="../css/loginstyle.css">
   <title>Login</title>
</head>
<body>

   <div class="container">
      
      <div class="box form-box">
        <header>LogIn</header>
      <form action="login.php" method="post">
         <div class="field input">
            <label for="name">Admin ID</label>
            <input type="text" name="name" id="name"  required>
         </div>
         <div class="field input">
            <label for="pass">Password</label>
            <input type="text" name="pass" id="pass" autocomplete="off" required>
         </div>
         <div class="field ">
             <input type="submit" class="btn" name="submit" value="Login" required>
         </div>


         
         
      </form>
   </div>

   </div>
</body>
</html>