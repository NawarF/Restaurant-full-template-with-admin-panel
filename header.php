<?php
include 'config.php';
?>
<header id='header'>
     <div class="container">
   <a href="" class='logo'>Foodies</a>

   <nav class='mineu'>
     <a href="admin.php" >Add Products</a>
     <a href="product.php">View Products</a>
   </nav>

<?php

$select_query = mysqli_query($conn ,"SELECT * FROM `cart`");
$row_count = mysqli_num_rows($select_query);
?>

<div class="shop-cart">
<a href="cart.php">Cart <span><?= $row_count ?></span></a>
</div>

<div class='fas fa-bars' style='font-size:12px' id='bar-btn' >

</div>
</div>
</header>








