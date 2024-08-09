<?php 
  require_once "../components/database.php";
if (isset($_POST['update'])) {
    
    $pid = $_POST['id'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $pname = $_POST['name'];
    $pname = filter_var($pname, FILTER_SANITIZE_STRING);
    $pprice = $_POST['price'];
    $pprice = filter_var($pprice, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE product SET name = ?, price = ? WHERE id = ?");
    $update_product->execute([$pname, $pprice, $pid]);
    $message[] = 'update sucess'; 

    $old_image = $_POST['old_img'];
    $image = $_FILES['image']['name'];
    $image =filter_var($image,FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'product_img/'.$image;

    if(!empty($image)){
        if($image_size > 2000000){
            $message = 'image size is too large';
        }else{
            $update_image = $conn->prepare("UPDATE product SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);
            move_uploaded_file($image_temp_name,$image_folder);
            unlink('product_img/'. $old_image);
        }
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
    <?php 
    include("../components/admin_header.php");
    require_once "../components/database.php";
    ?>
    <section class="add">
        <form action="update_product.php" method="POST" enctype="multipart/form-data">
        <h3>Update Product</h3>
        <?php 
        if (isset($_POST['id'])) {
            $updateid = $_POST['id'];

            $stmt = $conn->prepare("SELECT * FROM product WHERE ID = ?");
            $stmt->bind_param("i", $updateid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
        ?>
       
        <input type="hidden" name="id" value="<?php echo $fetch_products['ID']; ?>">
        <input type="hidden" name=old_img value="<?php echo $fetch_products['image']?>">
        <img src="product_img/<? $fetch_products['image']?>" alt="">
        <input type="text" required placeholder="enter product name" name="name" value="<?php echo $fetch_products['name']; ?>" maxlength="100" class="box">
        <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" value="<?php echo $fetch_products['price']; ?>" onkeypress="if(this.value.length == 10) return false;" class="box">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="Update Product" name="update" class="btn">
        <?php 
                }
            } else {
                echo "<p>No product found with the given ID.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>No ID provided.</p>";
        }
        ?>
        </form>
    </section>

</body>
</html>
