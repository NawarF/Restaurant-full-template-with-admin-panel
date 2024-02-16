<?php
include 'config.php';


if(isset($_POST['add_to_cart'])){
    $pname = $_POST['product_name'];
    $pprice = $_POST['product_price'];
    $pimage = $_POST['product_image'];
  $quntity =1;

  $select_query =mysqli_query($conn,"SELECT * FROM `cart` where name='$pname'") or die("select error");
  if(mysqli_num_rows($select_query) > 0){
    $message[] ="product is already added";
  }else{
$insert_query= mysqli_query($conn ,"INSERT INTO `cart` (name , price ,image ,quntity)
  VALUES('$pname' ,'$pprice' ,'$pimage' ,'$quntity') ;") or die("insert error");
    $message[] ="product added to the cart successfully";
  }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $msg){
        echo '<div class="message">
        <span>'.$msg.'</span>
        <i class="fas fa-times" onclick= "this.parentElement.style.display = `none`"></i>
        </div>';
    }
}
?>


<?php
include 'header.php';
?>

<section class="show-section">
<h1 class="title"> latest products</h1>
   <div class="box-container">
            <?php
            $select_query = mysqli_query($conn ,"SELECT * FROM `products`");
            if(mysqli_num_rows($select_query) > 0){
            while($row = mysqli_fetch_assoc($select_query)){
            ?>

            <form class="product-conatiner" method="POST">
                <div class="box">
            <img src="upload/<?= $row['image']; ?>" alt="">
            <div class="content">
            <h3 class="product-name"><?=  $row['name'];  ?></h3>
            <p class="product-price">$<?= $row['price']; ?>/-</p>
            <input type="hidden" name="product_image" value ="<?= $row['image']; ?>">
            <input type="hidden" name="product_name" value ="<?=  $row['name'];  ?>">
            <input type="hidden" name="product_price" value ="<?=  $row['price']; ?>">
            </div>
            <input type="submit" name='add_to_cart' value="Add to cart" class="cart-btn  btn">
                </div>

            </form>

            <?php
            };
            };
            ?>
   </div>
 


</section>
<script src='main.js'></script>
</body>
</html>