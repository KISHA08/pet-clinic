<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Blue<span>Pet</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="users_accounts.php">Users</a>
         <a href="doctor.php">Doctor Details</a>
         
      </nav>

      <div class="icons">
      <a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>  
   </section>

</header>