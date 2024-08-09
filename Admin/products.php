<?php
require_once("../components/database.php");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_VALIDATE_FLOAT);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'product_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `product` WHERE name = ?");
    $select_products->bind_param("s", $name);
    $select_products->execute(); 
    $select_products->store_result();

    if($select_products->num_rows > 0){
       $message[] = 'Product already exists'; 
    } else {
        if($image_size > 5000000){
            $message[] = 'Image size exceeds the limit';
        } else {
            if (move_uploaded_file($image_temp_name, $image_folder)) {
                $add_product = $conn->prepare("INSERT INTO `product` (name, price, image) VALUES (?, ?, ?)");
                $add_product->bind_param("sss", $name, $price, $image);
                $add_product->execute(); 
                $message[] = 'Successfully added';
            } else {
                $message[] = 'Failed to upload image';
            }
        }
    }
}

if(isset($_GET['delete'])){
    $deleteid = $_GET['delete'];

    $delete_product_img = $conn->prepare("SELECT * FROM product WHERE ID = ?");
    $delete_product_img->bind_param("i", $deleteid);
    $delete_product_img->execute();
    $delete_img = $delete_product_img->get_result()->fetch_assoc(); 

    if ($delete_img) {
        unlink('product_img/'.$delete_img['image']);
        
        $delete_product = $conn->prepare("DELETE FROM product WHERE ID = ?");
        $delete_product->bind_param("i", $deleteid);
        $delete_product->execute();
    }

    header('location: products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body> 
    <?php include("../components/admin_header.php");?>

    <section class="add">
        <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add Product</h3>
        <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
        <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="add product" name="submit" class="btn">
        </form>
       
    </section>

    <div class="container product-container">
        <?php
        $select_products = $conn->query("SELECT * FROM `product`");
        if ($select_products->num_rows > 0) {
        ?>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $select_products->fetch_assoc()) {
                        $productName = $row['name'];
                        $productPrice = $row['price'];
                        $productImage = $row['image'];
                    ?>
                        <tr>
                            <td><img class="product-img" src="product_img/<?php echo $productImage; ?>" alt="<?php echo $productName; ?>"></td>
                            <td><?php echo $productName;?></td>
                            <td>RS <?php echo $productPrice; ?></td>
                            <td>
                                <form action="update_product.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" name="submit" class="btn-update">Update</button>
                            </form>
                                <a href="products.php?delete=<?= $row['ID']; ?>">
                                    <button class="btn-delete" onclick="return confirm('Confirm delete this product?')">Delete</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p> No products found.</p> 
        <?php } ?>
    </div>
