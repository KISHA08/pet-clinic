<?php
if (isset($message)) {
    echo '
    <div class="message">
        <span>' . $message . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
}
?>

<header class="header fixed-top d-flex align-items-center">
    <section class="flex d-flex align-items-center justify-content-between">
        <a href="dashboard.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="../img/logo.png" alt="">
        <h1>Blue<span>Pet</span></h1>
</a>
        <nav class="navbar">
            <a href="dashboard.php">Home</a>
            <a href="products.php">Products</a>
            <a href="add_user.php">Users</a>
            <a href="doctor.php">Doctor Details</a>
        </nav>
        <div class="icons">
            <a href="../components/admin_logout.php" onclick="return confirm(\'logout from this website?\');" class="delete-btn">logout</a>
        </div>
    </section>
</header>
